<?php
/**
 * 
 */
class Disburse extends Application
{

	private $status = [0 => 'PENDING', 1 => 'SUCCESS', 3 => 'REJECT'];

	public function __construct()
	{
		$this->model('model_disburse');
	}

	public function index()
	{
		http_response_code(200);
		echo json_encode('Disburse');
	}

	public function transaction_post($id)
	{
		if ($id) {
			http_response_code(404);
			echo json_encode('Http not found!');
			die;
		}

		$input = json_decode(file_get_contents('php://input'), true);

		if (
			(isset($input['bank_code']) && $input['bank_code']) &&
			(isset($input['account_number']) && $input['account_number']) &&
			(isset($input['amount']) && $input['amount']) &&
			(isset($input['remark']) && $input['remark'])
		) {
			$this->model_disburse->amount = isset($input['amount']) ? $input['amount'] : '';
			$this->model_disburse->status = 0;
			$this->model_disburse->timestamp = date("Y-m-d H:i:s");
			$this->model_disburse->bank_code = isset($input['bank_code']) ? $input['bank_code'] : '';
			$this->model_disburse->account_number = isset($input['account_number']) ? $input['account_number'] : '';
			$this->model_disburse->beneficiary_name = 'PT FLIP';
			$this->model_disburse->remark = isset($input['remark']) ? $input['remark'] : '';
			$this->model_disburse->fee = 4000;

			$save_disburse = $this->model_disburse->save();

			if ($save_disburse) {
				$this->model_disburse->id = $save_disburse['id'];
				$stmt = $this->model_disburse->findOne();

				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->model_disburse->status = $this->status[$data['status']];
					$this->model_disburse->time_served = $data['time_served'];
				}

				http_response_code(200);
				echo json_encode($this->model_disburse);
			}
			else {
				http_response_code(500);
				echo json_encode('Internal server error!');
			}
		}
		else {
			http_response_code(500);
			echo json_encode('Request failed!');
		}
	}

	public function transaction_get($id)
	{
		$this->model_disburse->id = $id;
		$stmt = $this->model_disburse->findOne();

		$num = $stmt->rowCount();
		if ($num > 0) {
			while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$this->model_disburse->id = $data['id'];
				$this->model_disburse->amount = $data['amount'];
				$this->model_disburse->status = $this->status[$data['status']];
				$this->model_disburse->timestamp = $data['timestamp'];
				$this->model_disburse->bank_code = $data['bank_code'];
				$this->model_disburse->account_number = $data['account_number'];
				$this->model_disburse->beneficiary_name = $data['beneficiary_name'];
				$this->model_disburse->remark = $data['remark'];
				$this->model_disburse->receipt = $data['receipt'];
				$this->model_disburse->time_served = $data['time_served'];
				$this->model_disburse->fee = $data['fee'];
			}
		}
		else {
			http_response_code(200);
			echo json_encode('Data not found!');
			die;
		}

		http_response_code(200);
		echo json_encode($this->model_disburse);
	}

	public function transaction_put($id)
	{
		$input = json_decode(file_get_contents('php://input'), true);
		if (
			(isset($input['status']) && $input['status']) &&
			(isset($input['receipt']) && $input['receipt'])
		) {
			$this->model_disburse->id = $id;
			$stmt = $this->model_disburse->findOne();

			$num = $stmt->rowCount();
			if ($num > 0) {
				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->model_disburse->id = $data['id'];
					$this->model_disburse->amount = $data['amount'];
					$this->model_disburse->status = $data['status'];
					$this->model_disburse->timestamp = $data['timestamp'];
					$this->model_disburse->bank_code = $data['bank_code'];
					$this->model_disburse->account_number = $data['account_number'];
					$this->model_disburse->beneficiary_name = $data['beneficiary_name'];
					$this->model_disburse->remark = $data['remark'];
					$this->model_disburse->receipt = $data['receipt'];
					$this->model_disburse->time_served = $data['time_served'];
					$this->model_disburse->fee = $data['fee'];
				}

				if ($this->model_disburse->status != 0) {
					http_response_code(200);
					echo json_encode('Disburse status '. $this->status[$this->model_disburse->status] .', can not be process!');
					die;
				}
			}
			else {
				http_response_code(200);
				echo json_encode('Data not found!');
				die;
			}

			$this->model_disburse->status = $input['status'];
			$this->model_disburse->receipt = $input['receipt'];
			$this->model_disburse->time_served = date('Y-m-d H:i:s');

			$update_disburse = $this->model_disburse->update($id);

			if ($update_disburse) {
				$this->model_disburse->status = $this->status[$this->model_disburse->status];
				http_response_code(200);
				echo json_encode($this->model_disburse);
			}
			else {
				http_response_code(500);
				echo json_encode('Internal server error!');
			}
		}
		else {
			http_response_code(500);
			echo json_encode('Request failed!');
		}
	}
}
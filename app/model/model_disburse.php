<?php
/**
 * 
 */
class model_disburse extends Application
{
	private $connection;
	private $table_name = "disburse";

	public $id;
	public $amount;
	public $status;
	public $timestamp;
	public $bank_code;
	public $account_number;
	public $beneficiary_name;
	public $remark;
	public $receipt;
	public $time_served;
	public $fee;

	public function __construct($connection)
	{
		$this->connection = $connection;
	}

	public function transaction($value='')
	{
		# code...
	}

	public function findOne()
	{
		$id = $this->id;
		$query = "SELECT * FROM ". $this->table_name ." WHERE id = $id";

		$stmt = $this->connection->prepare($query);

		$stmt->execute();
		return $stmt;
	}

	public function save()
	{
		$query = "
			INSERT INTO
				". $this->table_name ."
			(
				amount, status, bank_code, account_number, beneficiary_name, remark, fee
			)
			VALUES
			(
				:amount, :status, :bank_code, :account_number, :beneficiary_name, :remark, :fee
			)
		";

		$stmt = $this->connection->prepare($query);

		$stmt->bindParam(':amount', $this->amount);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':bank_code', $this->bank_code);
		$stmt->bindParam(':account_number', $this->account_number);
		$stmt->bindParam(':beneficiary_name', $this->beneficiary_name);
		$stmt->bindParam(':remark', $this->remark);
		$stmt->bindParam(':fee', $this->fee);

		// execute query
		if ($stmt->execute()) {
			$result = [
				'id' => $this->connection->lastInsertId()
			];

			return $result;
		}

		return false;
	}

	public function update($id)
	{
		$query = "UPDATE ". $this->table_name ." SET  status = :status, receipt = :receipt, time_served = :time_served where id = $id";
	
		$stmt = $this->connection->prepare($query);

		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':receipt', $this->receipt);
		$stmt->bindParam(':time_served', $this->time_served);

		// execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
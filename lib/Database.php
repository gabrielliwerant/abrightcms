<?php

/**
 * TaskVolt
 * 
 * Project management, todo list, collaboration, and social web application tool
 * for consumers.
 * 
 * @package TaskVolt
 * @author Gabriel Liwerant
 * @link http://taskvolt.com
 */

/**
 * Database Class
 * 
 * Our database selection and connection is done here through PDO.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 * 
 * @uses PDO
 */
class Database extends PDO
{	
	/**
	 * Contains a list of all the database table names for reference.
	 *
	 * @var array $db_table
	 */
	public $db_table = array();
	
	/**
	 * Constructor runs the parent constructor for PDO.
	 * 
	 * We use the constructor to pass arguments for database connection, using
	 * constants defined elsewhere as default values. Also set up error 
	 * reporting if we are in debug mode.
	 * 
	 * @param string $db_type Database type
	 * @param string $db_host Database host
	 * @param string $db_name Database name
	 * @param string $db_user Database user name
	 * @param string $db_pass Database password
	 */
	public function __construct(
		$db_type = DB_TYPE,		
		$db_host = DB_HOST,		
		$db_name = DB_NAME,		
		$db_user = DB_USER,		
		$db_pass = DB_PASS
	)
	{
		parent::__construct(
			$db_type . ':host=' . $db_host . ';dbname=' . $db_name,
			$db_user, 
			$db_pass
		);
		
		if (IS_MODE_DEBUG) 
		{
			parent::setAttribute(PDO::ATTR_ERRMODE,	PDO::ERRMODE_EXCEPTION);
		}
	}
	
	/**
	 * Sets the database table names.
	 * 
	 * We use the set property to access table names so that we have a central
	 * place to change names.
	 *
	 * @param array $db_table_names The table names to store
	 */
	public function setDatabaseTableNames($db_table_names)
	{
		$this->db_table = $db_table_names;
	}
	
	/**
	 * Build a WHERE statement depending upon how many conditions we have.
	 * 
	 * @param array $where_data Our WHERE columns and corresponding values
	 * @return string WHERE clause with parameters to bind in prepared statement
	 */
	private function _buildWhereClause($where_data)
	{
		$i = 0;
		
		foreach($where_data as $where_column => $where_value)
		{
			if ($i > 0)
			{
				$where_clause_arr[] = " AND " . $where_column . " = :" . $where_column;
			}
			else
			{
				$where_clause_arr[] = "WHERE " . $where_column . " = :" . $where_column;
			}
			
			$i++;
		}
		
		$where_clause = implode($where_clause_arr);
		
		return $where_clause;
	}
	
	/**
	 * Build the list of columns for insertion into prepared statements.
	 * 
	 * @param array/string $column_data Contains our list or singular column
	 * @param string $table Used to specify column names
	 * @return string The built list of columns or single column name
	 */
	private function _buildColumnList($column_data, $table = null)
	{
		if (is_array($column_data))
		{
			if ( ! is_null($table))
			{
				$column_list = '';
				
				foreach ($column_data as $column_name)
				{
					$column_list .= $table . '.' . $column_name . ', ';
				}
			
				// Always remove the last two characters ", " to clean up the 
				// string.
				$column_length	= strlen($column_list);
				$column_list	= substr($column_list, 0, $column_length - 2);
			}
			else
			{
				$column_list = implode(', ', $column_data);
			}
		}
		else
		{
			if ( ! is_null($table))
			{
				$column_list = $table . '.' . $column_data;
			}
			else
			{
				$column_list = $column_data;
			}
		}
		
		return $column_list;
	}
	
	/**
	 * Binds values to parameters with column names that match for use in 
	 * preparing statements.
	 *
	 * @param array $bind_data The column => value pairs to bind
	 * @param string $statement The prepared statement to bind to
	 */
	private function _bindValues($bind_data, $statement)
	{
		foreach ($bind_data as $column => $value)
		{
			$statement->bindValue(':' . $column, $value);
		}
	}
	
	/**
	 * Executes a SELECT all query as a prepared statement.
	 * 
	 * First we prepare the statement with the database object. Then we make 
	 * sure we're using an associative array. Then we execute the statement and
	 * return the results.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @return array Results of the query
	 */
	public function selectAll($table)
	{
		$statement = $this->prepare("SELECT * FROM {$table}");
		
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
		
		return $statement->fetchAll();
	}
	
	/**
	 * Executes a SELECT all query with a WHERE clause as a prepared statement.
	 * 
	 * First we prepare the statement with the database object. Then we make 
	 * sure we're using an associative array. Then we execute the statement and
	 * return the results.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @param string $where_column Build the column part of the WHERE clause
	 * @param string/integer $where_value The value part of the WHERE clause
	 * @return array Results of the query
	 */
	public function selectAllWhere($table, $where_column, $where_value)
	{
		$statement = $this->prepare("
			SELECT * 
			FROM {$table} 
			WHERE {$table}.{$where_column} = :where_value");
		
		$statement->execute(array(':where_value' => $where_value));		
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		
		return $statement->fetchAll();
	}
	
	/**
	 * Executes a SELECT on a specific field in a table as a prepared statement.
	 * 
	 * First we prepare the statement with the database object. Then we make 
	 * sure we're using an associative array. Then we execute the statement and
	 * return the results.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @param string array/string $column_list Column(s) to select in the table
	 * @return array Results of the query
	 */
	public function selectColumn($table, $column_list)
	{
		$column	= $this->_buildColumnList($column_list, $table);
		
		$statement = $this->prepare("SELECT {$column} FROM {$table}");
		
		$statement->execute();		
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		
		return $statement->fetchAll();
	}
	
	/**
	 * Executes a SELECT on specific columns in a table with a WHERE clause as a
	 * prepared statement.
	 * 
	 * First we prepare the statement with the database object. Then we make 
	 * sure we're using an associative array. Then we execute the statement and
	 * return the results.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @param string array/string $column_list Column(s) to select in the table
	 * @param array $where_data Column names and corresponding values
	 * @return array Results of the query 
	 */
	public function selectColumnWhere($table, $column_list, $where_data)
	{
		$column			= $this->_buildColumnList($column_list, $table);		
		$where_clause	= $this->_buildWhereClause($where_data);
		
		$statement = $this->prepare("
			SELECT {$column} 
			FROM {$table} 
			$where_clause");
		
		$this->_bindValues($where_data, $statement);

		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		
		return $statement->fetchAll();
	}
	
    /**
     * Executes a SELECT on specific columns in a table with a WHERE clause and
     * an ORDER BY statement to sort the results as a prepared statement.
     * 
     * We prepare the statement with the proper values, set the fetch mode 
     * accordingly, and then return the results.
     * 
     * @param string $table Name of table on which to perform the query
     * @param string array/string $column_list Column(s) to select in the table
     * @param array $where_data Column names and corresponding values
     * @param string $order_column Column to order the results by
     * @param string $order_type The method by which to order the results
     * @return array Results of the query
     */
	public function selectColumnWhereOrder(
		$table, 
		$column_list, 
		$where_data,
		$order_column,
		$order_type
	)
	{
		$column			= $this->_buildColumnList($column_list, $table);
		$where_clause	= $this->_buildWhereClause($where_data);
		
		$statement = $this->prepare("
			SELECT {$column} 
			FROM {$table} 
			$where_clause 
			ORDER BY {$order_column} {$order_type}
		");
		
		$this->_bindValues($where_data, $statement);
 
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		
		return $statement->fetchAll();
	}
	
	/**
	 * Executes a SELECT that searches for a value with an aggregate function 
	 * in a column based on a WHERE clause as a prepared statement.
	 * 
	 * We build the SQL statement, bind the appropriate values, and make sure to
	 * send the result as a numeric array.
	 * 
	 * @param string $aggregate_function Aggregate select function
	 * @param string $table Name of table on which to perform the query
	 * @param string $column Name of the column to select value in table
	 * @param array $where_data Column names and corresponding values
	 * @param string $group_by_column Column to group by
	 * @return array Results of the query
	 */
	public function selectAggregateWhere(
		$aggregate_function,
		$table, 
		$column, 
		$where_data, 
		$group_by_column)
	{
		$where_clause = $this->_buildWhereClause($where_data);
		
		$statement = $this->prepare("
			SELECT $aggregate_function({$table}.{$column}) 
			FROM {$table} 
			$where_clause 
			GROUP BY {$table}.{$group_by_column}
		");

		$this->_bindValues($where_data, $statement);

		$statement->execute();		
		$statement->setFetchMode(PDO::FETCH_NUM);

		return $statement->fetchAll();
	}
	
	/**
	 * Executes an inner JOIN between two tables as a prepared statement.
	 *
	 * @param array/string $column_list Column(s) to select in the table
	 * @param string $select_table Table on which to perform SELECT
	 * @param string $where_table Table on which to compare for SELECT
	 * @param string $where_column Column on which to JOIN
	 * @return array Results of the JOIN
	 */
	public function InnerJoin(
		$column_list,
		$select_table, 
		$where_table, 
		$where_column
	)
	{
		$column_clause	= $this->_buildColumnList($column_list, $select_table);
		$table_clause	= $select_table . ', ' . $where_table;
		
		$statement = $this->prepare("
			SELECT $column_clause 
			FROM $table_clause 
			WHERE ({$select_table}.{$where_column} = {$where_table}.{$where_column})
		");
		
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_NUM);
		
		return $statement->fetchAll();
	}
	
	//
	//
	//
	public function leftJoin()
	{
		
	}
	
	//
	//
	//
	public function rightJoin(
		$table, 
		$column_list, 
		$join_table, 
		$join_column, 
		$where_column, 
		$where_value
	)
	{
		$column_clause	= $this->_buildColumnList($column_list, $table);
		
		$statement = $this->prepare("
			SELECT $column_clause 
			FROM {$table} 
			RIGHT JOIN {$join_table} 
			ON ({$table}.{$join_column} = {$join_table}.{$join_column}) 
			WHERE {$table}.{$where_column} = {$where_value}
		");
		//Debug::printArray($statement);
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_NUM);
		//Debug::printArray($statement->fetchAll());
		return $statement->fetchAll();
		
		//SELECT prod_name, supplier_name, supplier_address FROM product RIGHT JOIN suppliers 
		//ON (product.supplier_id = suppliers.supplier_id) WHERE supplier_name='Microsoft';
	}
	
	/**
	 * Executes an INSERT as a prepared statement.
	 * 
	 * We build the statement from a data array into the INSERT columns and 
	 * value placeholders, and then bind the placeholders with the actual data.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @param array $data Column names and corresponding values
	 * @return integer Id of the inserted statement
	 */
	public function insert($table, $data)
	{
		// Create a comma-separated list of of the column names from the data
		// array keys for binding in the prepared statement. Then create the 
		// parameter placeholders with the colon and the same array keys.
		$column_bind = implode(', ', array_keys($data));
		$value_bind = ':' . implode(', :', array_keys($data)); 
		
		$statement = $this->prepare("
			INSERT INTO {$table} ({$column_bind}) 
			VALUES ({$value_bind})
		");
		
		$this->_bindValues($data, $statement);

		$statement->execute();
		
		return $this->lastInsertId();
	}
	
	/**
	 * Executes an UPDATE that depends upon a WHERE clause as a prepared 
	 * statement.
	 * 
	 * We build the column names and bind values with our data, build the SQL 
	 * statement, bind the appropriate values, and send us the success value.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @param array $data Column names and corresponding values
	 * @param array $where_data Column names and corresponding values
	 * @return boolean Let us known if the statement execution was a success
	 */
	public function updateWhere($table, $data, $where_data)
	{
		$set_bind = '';
		
		foreach ($data as $key => $value)
		{
			$set_bind .= $key . ' = :' . $key . ', ';
		}

		// Always remove the last two characters ", " to clean up the string.
		$set_bind_length	= strlen($set_bind);
		$set_bind			= substr($set_bind, 0, $set_bind_length - 2);
		
		$where_clause = $this->_buildWhereClause($where_data);
		
		$statement = $this->prepare("
			UPDATE {$table} 
			SET {$set_bind} 
			$where_clause
		");
		
		$this->_bindValues($data, $statement);
		$this->_bindValues($where_data, $statement);
		
		$is_successful = $statement->execute();
		
		return $is_successful;
	}
	
	/**
	 * Executes an UPDATE using a CASE clause to handle multiple conditional
	 * SETs at once.
	 * 
	 * We build out our CASE statement using our when array and then implode it.
	 * After preparing the the statement, we bind the appropriate CASE clause 
	 * values and execute.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @param string $column Column on which to perform UPDATE
	 * @param string $case_column Column on which to execute CASE clause
	 * @param array $when_value_arr Key/value pairs to split into CASE clause
	 * @return boolean Let us known if the statement execution was a success 
	 */
	public function updateCase($table, $column, $case_column, $when_value_arr)
	{
		// Build a WHEN statement for each value, using the array key + 1 as the
		// new position.
		foreach($when_value_arr as $key => $id)
		{
			$when_clause_arr[] = "WHEN :when_value" . $id . " THEN " . ($key + 1) . PHP_EOL;
		}		
		$when_clause = implode($when_clause_arr);
		
		$statement = $this->prepare("
			UPDATE {$table} 
			SET {$column} = CASE {$case_column} $when_clause 
			ELSE {$column} 
			END
		");

		foreach ($when_value_arr as $id)
		{
			$statement->bindValue(':when_value' . $id, $id);
		}
			
		$is_successful = $statement->execute();
		
		return $is_successful;
	}
	
	/**
	 * Executes a DELETE as a prepared statement with a WHERE clause.
	 * 
	 * We build the SQL statement, bind the appropriate values, and return true
	 * or false depending upon whether or not the statement was executed 
	 * successfully.
	 * 
	 * @param string $table Name of table on which to perform the query
	 * @param array $where_data Column names and corresponding values
	 * @return boolean Let us known if the statement execution was a success
	 */
	public function deleteWhere($table, $where_data)
	{
		$where_clause = $this->_buildWhereClause($where_data);
		
		$statement = $this->prepare("
			DELETE FROM {$table} 
			$where_clause
		");
		
		$this->_bindValues($where_data, $statement);

		$is_successful = $statement->execute();

		return $is_successful;	
	}
}
// End of Database Class

/* EOF lib/Database.php */
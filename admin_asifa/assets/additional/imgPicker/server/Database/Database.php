<?php
/**
* Database
*/
class Database {
	/**
	 *	PDO connection instances
	 *	
	 *	@var PDO
	 */
	protected static $pdo = null;
	
	protected
			$query,
			$prefix = '',
			$query_type = '',
			$table   = '',
		 	$where   = '',
			$orderby = '',
		 	$limit   = '',
		 	$columns = array(),
		 	$bind    = array(),
			$data    = array(),
		 	$operators = array('=', '!=', '<', 
		 		'>', '>=','<=', 'in', 'not in'),

		 	$cfg = array(
				'driver'    => 'mysql',
				'database'  => '',
				'username'  => 'root',
				'password'  => '',
				'hostname'  => 'localhost',
				'prefix'    => '',
				'charset'   => 'utf8',
				'collation' => 'utf8_general_ci'
	 		),
	 		$cfg_file = 'config.php';

	/**
	 *	Constructor
	 * 
	 *	@return void
	 */
	public function __construct()
	{
		// Create new connection if not exists
		if (!self::$pdo) {
			$this->connect();
		}
	}

	/**
	 *	Connect
	 * 
	 *	@return void
	 */
	private function connect()
	{
		// Load config from /app/config/database.php
		$cfg = include dirname(__FILE__) .'/'. $this->cfg_file;

		$this->cfg = $cfg + $this->cfg;
		
		// Check for the PDO driver
		if (class_exists('PDO') === false) {
			exit('The PDO driver was not found. Enable the PDO driver in php.ini.');
		}

		try {
			self::$pdo = new PDO($cfg['driver'].':host='.$cfg['hostname'].';dbname='.$cfg['database'], 
				$cfg['username'], $cfg['password'],
				array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$cfg['charset']. ' COLLATE '.$cfg['collation']
				)
			);

			$this->prefix = $cfg['prefix'];

		} catch (PDOException $e) {
			exit('Unable to connect to the database.');
		}
	}

	/**
	 *	Insert
	 * 
	 * 	@param  array 		Data to be inserted array('column'=>'value')
	 *	@return Database 	Current instance (chaining)
	 */
	public function insert($data)
	{
		$this->query_type = 'insert';
		$this->data = $data;
		return $this->runQuery();
	}

	/**
	 *	Last insert ID
	 * 
	 *  @return integer
	 */
	public function insertGetId()
	{
		return self::$pdo->lastInsertId();
	}
	
	/**
	 *	Select
	 * 
	 * 	@param  string 		String: col1, col2 or Array array('col1', 'col2')
	 *	@return Database 	Current instance (chaining)
	 */
	public function select($columns = '*')
	{
		$this->query_type = 'select';
		$this->columns    = $columns;
		return $this;
	}

	/**
	 *	Get select results
	 * 
	 * 	@param  string 		Fetch style (obj/assoc)
	 *	@return mixed
	 */
	public function get($fetch = 'obj')
	{	
		switch ($fetch) {
			case 'assoc':
				$fetch = PDO::FETCH_ASSOC;
			break;
			default:
				$fetch = PDO::FETCH_OBJ;
			break;
		}

		if ($this->query_type != 'select') {
			$this->query_type = 'select';
			$this->columns    = '*';
		}	
		
		if ($this->runQuery()) {
			$results = $this->query->fetchAll($fetch);
			return $results;
		}
		return false;
	}

	/**
	 *	Update
	 * 
	 * 	@param  array 		Data to be updated array('column'=>'value')
	 *	@return Database 	Current instance (chaining)
	 */
	public function update($data)
	{
		$this->query_type = 'update';
		$this->data = $data;
		return $this->runQuery();
	}

	/**
	 *	Delete
	 * 
	 *	@return bool
	 */
	public function delete()
	{
		$this->query_type = 'delete';
		return $this->runQuery();
	}

	/**
	 *	Set table
	 * 
	 * 	@param  string
	 *	@return Database 		Current instance (chaining)
	 */
	public function table($table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 *	Where (AND)
	 * 
	 * 	@param  string 		Column name
	 * 	@param  string 		Column value
	 * 	@param  string 		Operator
	 * 	@param  string
	 *	@return Database 	Current instance (chaining)
	 */
	public function where($column, $value, $operator = '=', $join_op = 'AND')
	{
		$operator = strtolower($operator);
		if (!in_array($operator, $this->operators)) {
			$operator = '=';
		}

		if (!empty($this->where)) {
			if (in_array(strtolower($join_op), array('and', 'or'))) {
				$this->where .= " $join_op ";
			} else {
				$this->where .= ' AND ';
			}
		}

		$this->where .= " $column $operator";
		
		if ($operator == 'in' || $operator == 'not in') {
			$values = implode(',', array_fill(0, count($value), '?'));
			$this->where .= ' ('.$values.') ';
		} else {
			$this->where .= ' ? ';
		}

		if (is_array($value)) {
			foreach ($value as $val) {
				$this->bind[] = $val;
			}
		} else {
			$this->bind[] = $value;
		}

		return $this;
	}

	/**
	 *	Where (OR)
	 *
	 * 	@param  string 		Column name
	 * 	@param  string 		Column value
	 * 	@param  string 		Operator
	 * 	@param  string
	 *	@return Database 	Current instance (chaining)
	 */
	public function orWhere($column, $value, $operator = '=')
	{
		return $this->where($column, $value, $operator, 'OR');
	}

	/**
	 *	Where (IN)
	 * 
	 * 	@param  string 		Column name
	 * 	@param  array 		Column values
	 *	@return Database 	Current instance (chaining)
	 */
	public function whereIn($column, $values)
	{
		return $this->where($column, $values, 'IN');
	}

	/**
	 *	Where (NOT IN)
	 * 
	 * 	@param  string 		Column name
	 * 	@param  array 		Column values
	 *	@return Database 	Current instance (chaining)
	 */
	public function whereNotIn($column, $values)
	{
		return $this->where($column, $values, 'NOT IN');
	}

	/**
	 *	Order By
	 * 
	 * 	@param  string 
	 * 	@param  string
	 *	@return Database 		Current instance (chaining)
	 */
	public function orderBy($columns, $order = 'ASC')
    {
        if (!is_array($columns)) {
            $columns = array($columns);
        }

        foreach($columns as $column) {
            $column = $column . ' ' . $order;
            if (!empty($this->orderby)){
            	$this->orderby .= ', ' . $column;
            } else {
            	$this->orderby = $column;
            }
        }

        return $this;
    }

    /**
	 *	Limit
	 * 
	 * 	@param  integer 
	 * 	@param  integer
	 *	@return Database 		Current instance (chaining)
	 */
    public function limit($limit, $range = null)
	{
		if ( is_numeric($limit) ) {
            $this->limit = $limit;

            if ( !empty($range) && is_numeric($range) ) {
	            $this->limit .= ", $range";
	        }
        }

        return $this;
    }

    /**
	 *	Reset
	 * 
	 *	@return void
	 */
	protected function reset()
	{
		$this->query_type = '';
		$this->table   = '';
	 	$this->where   = '';
		$this->orderby = '';
	 	$this->limit   = '';
	 	$this->columns = array();
	 	$this->bind    = array();
		$this->data    = array();
	}

	 /**
	 *	Build & run query
	 * 
	 *  @return bool
	 */
	protected function runQuery()
	{
		$sql_query = '';
		$table = $this->prefix . $this->table;
		
		switch ($this->query_type) {
			case 'insert':
				if (!count($this->data)) {
					return false;
				}
				
				foreach ($this->data as $key => $value) {
					$this->columns[] = $key;
					$this->bind[] = $value;
				}

				$values  = implode(',', array_fill(0, count($this->columns), '?'));
				$columns = implode(',', $this->columns);
				$sql_query .= 'INSERT INTO '.$table.' ('.$columns.') VALUES('.$values.')';
			break;
			
			case 'select':
				if (is_array($this->columns)) {
					$this->columns = implode(',', $this->columns);
				}
				$sql_query .= 'SELECT '.$this->columns.' FROM '.$table;
			break;

			case 'update':
				$bind = $this->bind;
				$this->bind = array();

				$sql_query .= 'UPDATE '.$table.' SET ';
				if (count($this->data)) {
					foreach ($this->data as $key => $value) {
						$sql_query .= $key.'=?,';
						$this->bind[] = $value;
					}
					$sql_query = substr($sql_query, 0, strlen($sql_query) - 1);
				}

				if (count($bind)) {
					foreach ($bind as $value) {
						$this->bind[] = $value;
					}
				}
			break;

			case 'delete':
				$sql_query .= 'DELETE FROM '.$table;
			break;
		}

		if (!empty($this->where)) {
			$sql_query .= ' WHERE '.$this->where;
		}

		if (!empty($this->orderby)) {
			$sql_query .= ' ORDER BY '.$this->orderby;
		}

		if (!empty($this->limit)) {
			$sql_query .= ' LIMIT '.$this->limit;
		}

		$bind = $this->bind;
		$this->reset();

		if ( $this->query = self::$pdo->prepare($sql_query) ) {
			if (count($bind)) {
				$k = 1;
				foreach ($bind as $value) {
					$this->query->bindValue($k, $value);
					$k ++;
				}
			}
			
			if ($this->query->execute()) {
				return true;
			}

		}
		return false;
	}
}
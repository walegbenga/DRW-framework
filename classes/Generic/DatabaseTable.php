<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 18/12/18
* Time : 21:56
*/

namespace Generic;

class DatabaseTable {
    private $pdo;
    private $table;
    private $primaryKey;
    private $className;
    private $constructorArgs;

    public function __construct(\PDO $pdo, string $table, string $primaryKey, string $className = '\stdClass', array $constructorArgs = []) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
        $this->constructorArgs = $constructorArgs;
    }

    private function query($sql, $parameters = []) {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }   

    public function total($field = null, $value = null) {
        $sql = 'SELECT COUNT(*) FROM `' . $this->table . '`';
        $parameters = [];

        if (!empty($field)) {
            $sql .= ' WHERE `' . $field . '` = :value';
            $parameters = ['value' => $value];
        }
        
        $query = $this->query($sql, $parameters);
        $row = $query->fetch();
        return $row[0];
    }

    //Updated on 23-12-18 with the search method 2

    /*public function totalSearch($field = null, $value = null,  $allWords = 'on'){
        $parameters = [];
        $query = 'SELECT COUNT(*) FROM `' . $this->table . '`';

        if(!empty($fields && $allWords == true)){
            $query .= ' WHERE MATCH(`' . $field . '` = :value)';
            $parameters = ['value' => $value];
        }

        $query = $this->query($query, $parameters);
        $row = $query->fetch();
        return $row[0];
    }*/

    public function totalSearch(array $fields = null, array $values = null, $allWords = null){
        $parameters = [];
        $query = 'SELECT COUNT(*) FROM `' . $this->table . '`';

        if(!empty($fields)){
            foreach ($fields as $field) {
                foreach ($values as $value) {
                    if($allWords == 'on' || $allWords == null){
                        $query .= ' WHERE MATCH(`' . $field . '` = :value IN BOOLEAN MODE)';
                    }else{
                        $query .= ' WHERE MATCH(`' . $field . '` = :value)';
                    }
                }
            }
        }

        $parameters = ['value' => $value];

        $query = $this->query($query, $parameters);
        $row = $query->fetch();
        return $row[0];
    }

    public function findById($value) {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :value';

        $parameters = [
            'value' => $value
        ];

        $query = $this->query($query, $parameters);

        return $query->fetchObject($this->className, $this->constructorArgs);
    }

    //Updated on 23-12-18 with the search method 1
    
    /*public function search( $columns,  $values, $orderBy = null, $limit = null, $offset = null, $allWords = 'on'){
        $query = 'SELECT * FROM `' . $this->table . '` WHERE MATCH (`'; //'`) AGAINST(`' .  . '` IN BOOLEAN MODE)';
        
        foreach ($columns as $column) {
            $query .= $column;
        }

        $query = rtrim($query, ',');
        
        $query .= ')';

        if($allWords == 'on'){
            $query .= 'AGAINST( :value IN BOOLEAN MODE) ';
        }else{
            $query .= 'AGAINST( :value) ';
        }

        $parameters  = ['value' => $values];

        if($orderBy != null){
            $query .='ORDER BY MATCH (';
        
            foreach ($values as $value) {
                $query .= $value;
            }
        
            $query = rtrim($query, ',');
        
            $query .= ')';
            if($allWords == 'on'){
                'AGAINST (:value IN BOOLEAN MODE)';
            }else{
                $query.= 'AGAINST (:value)';
            }
        }

        if($orderBy != null){
            $query .= ' ' . $orderBy;
        }

        if($limit != null){
            $query .= ' LIMIT ' . $limit;
        }

        if($offset != null){
            $query .=  ' OFFSET ' . $offset;
        }

        $query = $this->query($query, $parameters);

        return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }*/

    //Original one
    public function search($column, $value, $orderBy = null, $limit = null, $offset = null, $allWords = null) {
        // Parameter $distinct added on 20/12/18
        //$query = 'SELECT * FROM `' . $this->table . '` WHERE MATCH (`' . $column . '`) AGAINST( :value IN BOOLEAN MODE) ORDER BY MATCH (' . $column . ') AGAINST(:value IN BOOLEAN MODE)DESC';
        $query = 'SELECT * FROM ' . $this->table . ' WHERE MATCH (' . $column . ') AGAINST(:value';
        if($allWords == 'on'){
            $query .= ' IN BOOLEAN MODE';
        }
        $query .= ')';
        
        $parameters = [
            'value' => $value
        ];

        if ($orderBy != null) {
            $query .= ' ORDER BY MATCH (' . $column . ') AGAINST(:value ';//IN BOOLEAN MODE) DESC';
            if($allWords == 'on'){
                $query .= 'IN BOOLEAN MODE';
            }
            $query .= ') ' . $orderBy;
        }

        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }

        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $query = $this->query($query, $parameters);

        return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    //Original 2
    /*public function search($columns = [], $value, $orderBy = null, $limit = null, $offset = null, $allWords = null) {
        // Parameter $distinct added on 20/12/18
        $query = 'SELECT * FROM ' . $this->table . ' WHERE MATCH (';
        foreach ($columns as $key => $value) {
            $query .= '`' . $key . '`,';
        }
        $query = rtrim($column, ',');

        $query .= ') AGAINST(:value';
         
        if($allWords == 'on'){
            $query .= ' IN BOOLEAN MODE';
        }
        $query .= ')';
        
        $parameters = [
            'value' => $value
        ];

        if ($orderBy != null) {
            $query .= ' ORDER BY MATCH (' . $column . ') AGAINST(:value ';
            if($allWords == 'on' || $allWords == null){
                $query .= 'IN BOOLEAN MODE ';
            }
            $query .= ')';
        }
        $query .= ')';

        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }

        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $query = $this->query($query, $parameters);

        return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }*/

    public function find($column, $value, $orderBy = null, $limit = null, $offset = null, $distinct = null) {
        // Parameter $distinct added on 20/12/18
        //$query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';
        $query = 'SELECT ';
        if($distinct != null){
            $query .= /*'DISTINCT ' */$distinct . ' ';
        }
        $query .= '* FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

        $parameters = [
            'value' => $value
        ];

        if ($orderBy != null) {
            $query .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }

        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $query = $this->query($query, $parameters);

        return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    // Added on 30/12/18. This function allows you to use COLEACSE, NULLIF, and another column to trim down the result return by the find query
    /*public function find($column, $value, $orderBy = null, $limit = null, $offset = null, $distinct = null, $coleasce = null, $nullIf = null, $columnAgainst = null) {
        // Parameter $distinct added on 20/12/18
        //$query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';
        $query = 'SELECT ';
        if($distinct != null){
            $query .= /*'DISTINCT ' *///$distinct . ' ';
        /*}
        $query .= '* FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

        $parameters = [
            'value' => $value
        ];

        if ($orderBy != null) {
            $query .= ' ORDER BY ' . $orderBy;
        }

        /*if($coleasce != null){
            $query .= ' ' . $coleasce . '(';
            if($nullIf != null){
                $query .= $nullIf . '('
            }
        }*/

       /* if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }

        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $query = $this->query($query, $parameters);

        return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }*/
    private function insert($fields) {
        $query = 'INSERT INTO `' . $this->table . '` (';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`,';
        }

        $query = rtrim($query, ',');

        $query .= ') VALUES (';


        foreach ($fields as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ')';

        $fields = $this->processDates($fields);

        $this->query($query, $fields);

        return $this->pdo->lastInsertId();
    }


    private function update($fields) {
        $query = ' UPDATE `' . $this->table .'` SET ';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';

        //Set the :primaryKey variable
        $fields['primaryKey'] = $fields[$this->primaryKey];

        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

    public function delete($id) {
        $parameters = [':id' => $id];

        $this->query('DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id', $parameters);
    }

    public function deleteWhere($column, $value) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

        $parameters = [
            'value' => $value
        ];

        $query = $this->query($query, $parameters);
    }

    public function findAll($orderBy = null, $limit = null, $offset = null) {
        $query = 'SELECT * FROM ' . $this->table;

        if ($orderBy != null) {
            $query .= ' ORDER BY ' . $orderBy;
        }

        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }

        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $result = $this->query($query);

        return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    private function processDates($fields) {
        foreach ($fields as $key => $value) {
            if ($value instanceof \DateTime) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }

        return $fields;
    }


    public function save($record) {
        $entity = new $this->className(...$this->constructorArgs);

        try {
            if ($record[$this->primaryKey] == '') {
                $record[$this->primaryKey] = null;
            }
            $insertId = $this->insert($record);

            $entity->{$this->primaryKey} = $insertId;
        }
        catch (\PDOException $e) {
            $this->update($record);
        }

        foreach ($record as $key => $value) {
            if (!empty($value)) {
                $entity->$key = $value; 
            }           
        }

        return $entity; 
    }
}
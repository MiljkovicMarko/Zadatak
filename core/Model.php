<?php
    namespace App\Core;

    abstract class Model {
        private $dbc;

        final public function __construct(DatabaseConnection &$dbc) {
            $this->dbc = $dbc;
        }

        protected function getFields(): array {
            return [];
        }

        final protected function getConnection() {
            return $this->dbc->getConnection();
        }

        final private function getTableName(): string {
            $matches = [];
            preg_match('|^.*\\\((?:[A-Z][a-z]+)+)Model$|', static::class, $matches);
            return substr(strtolower(preg_replace('|[A-Z]|', '_$0', $matches[1] ?? '')), 1);
        }

        final public function getById(int $id) {
            $tableName = $this->getTableName();
            $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $tableName . '_id = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute([$id]);
            $item = NULL;
            if ($res) {
                $item = $prep->fetch(\PDO::FETCH_OBJ);
            }
            return $item;
        }

        final public function getAll(): array {
            $tableName = $this->getTableName();
            $sql = 'SELECT * FROM ' . $tableName . ';';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

        final public function isFieldValueValid(string $fieldName, $fieldValue): bool {
            $fields = $this->getFields();
            $supportedFieldNames = array_keys($fields);

            if (!in_array($fieldName, $supportedFieldNames)) {
                throw new Exception('Invalid field name: ' . $fieldName);
            }

            return $fields[$fieldName]->isValid($fieldValue);
        }

        final private function isFieldNameValid(string $fieldName): bool {
            $fields = $this->getFields();
            $supportedFieldNames = array_keys($fields);

            return in_array($fieldName, $supportedFieldNames);
        }

        final public function getByFieldName(string $fieldName, $value) {
            if (!$this->isFieldValueValid($fieldName, $value)) {
                throw new Exception('Invalid field name or value: ' . $fieldName);
            }

            $tableName = $this->getTableName();
            $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $fieldName . ' = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute([$value]);
            $item = NULL;
            if ($res) {
                $item = $prep->fetch(\PDO::FETCH_OBJ);
            }
            return $item;
        }

        final public function getByFieldNames(array $fieldNames, array $values) {
            if(count($fieldNames)!=count($values))
            {
                throw new \Exception('The number of field names doesn\'t match the number of corresponding values!');
            }
            for ($i = 0; $i < count($fieldNames); $i++) {
                if (!$this->isFieldValueValid($fieldNames[$i], $values[$i])) {
                    throw new \Exception('Invalid field name or value: ' . $fieldNames[$i]);
                }
            } 

            $tableName = $this->getTableName();
            $sql='SELECT * FROM ' . $tableName . ' WHERE ';
            for ($i = 0; $i < count($fieldNames)-1; $i++) {
                $sql .= $fieldNames[$i] . ' = ?' . ' AND ';
            }
            $sql .= $fieldNames[count($fieldNames)-1] . ' = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute($values);
            $item = NULL;
            if ($res) {
                $item = $prep->fetch(\PDO::FETCH_OBJ);
            }
            return $item;
        }

        final public function getAllByFieldName(string $fieldName, $value): array {
            if (!$this->isFieldValueValid($fieldName, $value)) {
                throw new \Exception('Invalid field name or value: ' . $fieldName);
            }

            $tableName = $this->getTableName();
            $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $fieldName . ' = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute([$value]);
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

        final public function executeCustomSQL(string $sql, $values): array
        {
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute($values);
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

        final public function getAllByFieldNames(array $fieldNames, array $values): array {//dodao//mozda treba uraditi neke provere ili onaj bind parametara?!
            if(count($fieldNames)!=count($values))
            {
                throw new \Exception('The number of field names doesn\'t match the number of corresponding values!');
            }
            for ($i = 0; $i < count($fieldNames); $i++) {
                if (!$this->isFieldValueValid($fieldNames[$i], $values[$i])) {
                    throw new \Exception('Invalid field name or value: ' . $fieldNames[$i]);
                }
            } 

            $tableName = $this->getTableName();
            $sql='SELECT * FROM ' . $tableName . ' WHERE ';
            for ($i = 0; $i < count($fieldNames)-1; $i++) {
                $sql .= $fieldNames[$i] . ' = ?' . ' AND ';
            }
            $sql .= $fieldNames[count($fieldNames)-1] . ' = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute($values);
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

        final public function getOrderedByFieldNames(array $fieldNames, array $values,array $orderBy, array $asc): array {//dodao//mozda treba uraditi neke provere ili onaj bind parametara?!
            if(count($fieldNames)!=count($values))
            {
                throw new \Exception('The number of field names doesn\'t match the number of corresponding values!');
            }
            for ($i = 0; $i < count($fieldNames); $i++) {
                if (!$this->isFieldValueValid($fieldNames[$i], $values[$i])) {
                    throw new \Exception('Invalid field name or value: ' . $fieldNames[$i]);
                }
            } 
            for ($i = 0; $i < count($orderBy); $i++) {
                if (!$this->isFieldNameValid($orderBy[$i])) {
                    throw new \Exception('Invalid order by field name: ' . $orderBy[$i]);
                }
            } 
            if(count($orderBy)!=count($asc) || count($orderBy)<1)
            {
                throw new \Exception('The number of order by variables isn\'t greater than zero or it doesn\'t match the number of corresponding asc values!');
            }
            $tableName = $this->getTableName();
            $sql='SELECT * FROM ' . $tableName . ' WHERE ';
            for ($i = 0; $i < count($fieldNames)-1; $i++) {
                $sql .= $fieldNames[$i] . ' = ?' . ' AND ';
            }
            $sql .= $fieldNames[count($fieldNames)-1] . ' = ?';
            $sql .= ' ORDER BY '. $orderBy[0] . ($asc[0]?' ASC':' DESC');
            for ($i = 1; $i < count($orderBy); $i++) {
                $sql .= ','.$orderBy[$i] . ($asc[i]?' ASC':' DESC');
            }
            $sql .= ';';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute($values);
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }


        final private function checkFieldList(array $data) {
            $fields = $this->getFields();

            $supportedFieldNames = array_keys($fields);
            $requestedFieldNames = array_keys($data);

            foreach ( $requestedFieldNames as $requestedFieldName ) {
                if (!in_array($requestedFieldName, $supportedFieldNames)) {
                    throw new \Exception('Polje ' . $requestedFieldName . ' nije podržano!');
                }

                if ( !$fields[$requestedFieldName]->isEditable() ) {
                    throw new \Exception('Polje ' . $requestedFieldName . ' nije izmenjivo!');
                }

                if ( !$fields[$requestedFieldName]->isValid($data[$requestedFieldName]) ) {
                    throw new \Exception('Vrednost za polje ' . $requestedFieldName . ' nije validna!');
                }
            }
        }

        final public function add(array $data) {
            $this->checkFieldList($data);

            $tableName = $this->getTableName();

            $sqlFieldNames = implode(', ', array_keys($data));

            $questionMarks = str_repeat('?,', count($data));
            $questionMarks = substr($questionMarks, 0, -1);

            $sql = "INSERT INTO {$tableName} ({$sqlFieldNames}) VALUES ({$questionMarks});";
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute(array_values($data));
            if (!$res) {
                return false;
            }

            return $this->dbc->getConnection()->lastInsertId();
        }

        final public function editById(int $id, array $data) {
            $this->checkFieldList($data);

            $tableName = $this->getTableName();

            $editList = [];
            $values = [];
            foreach ($data as $fieldName => $value) {
                $editList[] = "{$fieldName} = ?";
                $values[] = $value;
            }
            $editString = implode(', ', $editList);

            $values[] = $id;

            $sql = "UPDATE {$tableName} SET {$editString} WHERE {$tableName}_id = ?;";
            $prep = $this->dbc->getConnection()->prepare($sql);
            return $prep->execute($values);
        }

        final public function deleteById(int $id) {
            $tableName = $this->getTableName();
            $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $tableName . '_id = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            return $prep->execute([$id]);
        }
    }

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
    }

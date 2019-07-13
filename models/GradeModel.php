<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;
    use App\Validators\BitValidator;

    class GradeModel extends Model {
        protected function getFields(): array {
            return [
                'grade_id'    => new Field((new NumberValidator())->setIntegerLength(10), false),
                'student_id'    => new Field((new NumberValidator())->setIntegerLength(10)),
                'grade'          => new Field((new StringValidator())->setMaxLength(50) )
            ];
        }
        public function getGradesByStudentId(int $id): array {
            $sql = 'SELECT '. 'grade'.' FROM ' . 'grade' . ' WHERE ' . 'student_id' . ' = ?;';
            $values = [$id];
            return $this->executeCustomSQL($sql, $values);
        }
        
    }

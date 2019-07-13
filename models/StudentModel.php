<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;
    use App\Validators\BitValidator;

    class StudentModel extends Model {
        protected function getFields(): array {
            return [
                'student_id'    => new Field((new NumberValidator())->setIntegerLength(10), false),
                'name'          => new Field((new StringValidator())->setMaxLength(50) ),
                'school_board'  => new Field((new StringValidator())->setMaxLength(4) )
            ];
        }
    }

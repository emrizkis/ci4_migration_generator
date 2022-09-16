<?php

namespace App\Controllers\Coaching;

use App\Controllers\BaseController;
use App\Models\CoachingDatabaseModel;

class CoachingMigrationGenerator extends BaseController
{

    public function index()
    {
        $model = new CoachingDatabaseModel();
        $tables = $model->listTables();
        $model->generateMigration($tables);
    }
}

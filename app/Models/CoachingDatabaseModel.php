<?php

namespace App\Models;

use CodeIgniter\Model;

class CoachingDatabaseModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'coaching';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];


    /**
     * dir
     * - directory saved files
     *
     * @var string
     */
    // protected $dir    = "app/Database/Migrations/generate-result/";
    protected $dir    = "app/Database/Migrations/";


    /**
     * getField
     * - This is function for getting fields in table
     * 
     * @return string
     */
    public function getField()
    {
        $fields = $this->getFieldNames($this->table);

        $listField = "[";
        foreach ($fields as $field) {
            $listField .= "'";
            $listField .= $field;
            $listField .= "' ,";
        }
        $listField .= "]";

        dd($listField);
    }


    /**
     * generateMigration
     *
     * @param  array $field
     * @return file in $dir directory
     */
    public function generateMigration(array $field)
    {

        if (is_array($field)) {
            foreach ($field as $key) {
                echo "\n\nGenerate $key.php file";
                $this->generateFile($key);
            }
        }

        echo "\n\nProses Selesai";
        exit;
        return;
    }

    /**
     * generateFile
     *
     * @param  string $db_name 
     * @return boolean
     */
    private function generateFile($db_name)
    {
        $fields = $this->getFieldData($db_name);
        $data = "<?php

        namespace App\Database\Migrations;
        
        use CodeIgniter\Database\Migration;
        
        class $db_name extends Migration
        {

            protected \$DBGroup = '$this->DBGroup';

            public function up()
            {
                \n\t\t\t\t\$fields =[\n";




        $primaryKey = null;

        foreach ($fields as $field) {
            $data .= "\t\t\t\t'$field->name' => [" . PHP_EOL;

            $type = $field->type;
            $max_length = (!$field->max_length) ? '' : "($field->max_length)";

            $type = "'$type$max_length'";
            $data .= "\t\t\t\t\t" . "'type'=>"  . $type . "," . PHP_EOL;
            $data .= "\t\t\t\t\t'null'=>true" . PHP_EOL;


            // INI BELUM TERSEDIA UNTUK SQL SERVER
            if (isset($field->primary_key)) {
                if ($field->primary_key) {
                    $primaryKey = $field->name;
                }
            }

            $data .= "\t\t\t\t]," . PHP_EOL;
        }

        $data .= "\t\t\t\t];";


        if ($primaryKey) {
            $data .= PHP_EOL . "\t\t\t\t\$this->forge->addKey('$primaryKey', true);";
        }

        $dir = $this->dir;

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        } else {
            echo "\n\nThe directory  $dir exists.";
            echo "\nThe directory  $dir will be deleted.";
        }

        $data .= "\n\n";
        $data .= "\t\t\t\t\$this->forge->addField(\$fields);";
        $data .= "\n\t\t\t\t" . '$this->forge->createTable("' . $db_name . '");';


        $data .= "
                    //
                }

                public function down()
                {
                    \$this->forge->createTable('$db_name');
                }
            }
            ";

        $myfile = fopen($dir . date("Y-m-d-his_") . $db_name . ".php", "w") or die("Unable to open file!");
        fwrite($myfile,  $data);

        fclose($myfile);
        return true;
    }
}

<?php

        namespace App\Database\Migrations;
        
        use CodeIgniter\Database\Migration;
        
        class trail_log extends Migration
        {

            protected $DBGroup = 'default';

            public function up()
            {
                
				$fields =[
				'record' => [
					'type'=>'int(11)',
					'null'=>true
				],
				'created_at' => [
					'type'=>'datetime',
					'null'=>true
				],
				'activity_code' => [
					'type'=>'varchar(50)',
					'null'=>true
				],
				'user_agent' => [
					'type'=>'varchar(200)',
					'null'=>true
				],
				'ip_address' => [
					'type'=>'varchar(100)',
					'null'=>true
				],
				'mac_address' => [
					'type'=>'varchar(100)',
					'null'=>true
				],
				'user_id' => [
					'type'=>'varchar(100)',
					'null'=>true
				],
				'user_name' => [
					'type'=>'varchar(150)',
					'null'=>true
				],
				'updated_at' => [
					'type'=>'datetime',
					'null'=>true
				],
				'deleted_at' => [
					'type'=>'datetime',
					'null'=>true
				],
				];
				$this->forge->addKey('record', true);

				$this->forge->addField($fields);
				$this->forge->createTable("trail_log");
                    //
                }

                public function down()
                {
                    $this->forge->createTable('trail_log');
                }
            }
            
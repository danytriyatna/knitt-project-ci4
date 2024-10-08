<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ViewRolePriv extends Migration
{
    public function up()
    {
        $db = db_connect();

        $query = "
                CREATE VIEW v_sec_role_priv
                AS SELECT
                a.role_id AS role_id,
                a.module_id AS module_id,
                a.allow_view AS allow_view,
                a.allow_new AS allow_new,
                a.allow_edit AS allow_edit,
                a.allow_delete AS allow_delete,
                a.allow_print AS allow_print,
                b.name AS module_name,
                b.alias AS module_alias,
                b.url AS module_url,
                b.pid AS module_pid,
                b.icon_cls AS mod_icon_cls,
                b.seq AS mod_seq,
                b.publish AS publish,
                b.group AS mod_group,
                a.allow_approve AS allow_approve
                FROM (sec_role_priv a left join sec_modul b on(a.module_id = b.id))";

        $db->query($query);
    }

    public function down()
    {
		$this->forge->dropTable('v_sec_role_priv');
    }
}

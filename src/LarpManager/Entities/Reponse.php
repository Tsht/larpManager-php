<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-07-02 13:41:53.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use LarpManager\Entities\BaseReponse;

/**
 * LarpManager\Entities\Reponse
 *
 * @Entity()
 */
class Reponse extends BaseReponse
{
	public function setReponse($reponse)
	{
		$hash = sha1($reponse);
		parent::setReponse($hash);
		return $this;
	}
}
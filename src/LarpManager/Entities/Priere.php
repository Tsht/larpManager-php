<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-07-02 09:07:29.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use LarpManager\Entities\BasePriere;

/**
 * LarpManager\Entities\Priere
 *
 * @Entity()
 */
class Priere extends BasePriere
{
	public function fullLabel()
	{
		return $this->getSphere()->getLabel() . " - " . $this->getNiveau() . " - " . $this->getLabel();
	}
}
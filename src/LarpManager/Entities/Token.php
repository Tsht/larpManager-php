<?php

/**
 * LarpManager - A Live Action Role Playing Manager
 * Copyright (C) 2016 Kevin Polez
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-08-03 07:13:54.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use LarpManager\Entities\BaseToken;

/**
 * LarpManager\Entities\Token
 *
 * @Entity(repositoryClass="LarpManager\Repository\TokenRepository")
 */
class Token extends BaseToken
{
	/**
	 * Fourni la description sans les tags html de mise en forme
	 */
	public function getDescriptionRaw()
	{
		return html_entity_decode(strip_tags($this->getDescription()));
	}
	
	public function getExportValue()
	{
		return array(
			$this->getId(),
			$this->getLabel(),
			$this->getTag(),
			utf8_decode($this->getDescriptionRaw()),
		);
	}
}
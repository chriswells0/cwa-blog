<?php
/*
 * Copyright (c) 2014 Chris Wells (https://chriswells.io)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

use \CWA\DB\DatabaseMapping;
use \CWA\MVC\Models\DatabaseRecord;

require_once \CWA\LIB_PATH . 'cwa/mvc/models/DatabaseRecord.php';
require_once 'Tag.php';

class BlogEntry extends DatabaseRecord
{
	/* Private variables */
	private $preview;


	/* Protected variables: */
	protected static $altKeyName = 'Slug';


	/* Public methods: */

	public function getPreview($elements) {
		if (!isset($this->preview)) {
			if (!isset($elements)) $elements = 2;
			// Get just the text (no markup) from a node using $node->textContent.
			// Compare the textContent value to the one returned by $node->nodeValue.
			libxml_use_internal_errors(true);
			$dom = new DomDocument();
			$dom->preserveWhiteSpace = false;
			$dom->loadHTML('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>' . $this->Body . '</body></html>');
			$dom->normalize();
			$nodes = $dom->getElementsByTagName("body")->item(0)->childNodes;
			$elementCount = 0;
			$this->preview = '';
			foreach ($nodes as $node) {
				if ($node->nodeType === XML_ELEMENT_NODE) {
					$this->preview .= $dom->saveXML($node);
					$elementCount++;
					if ($elementCount === $elements) break;
				}
			}
			// Carriage returns in the XML prevent the markup from validating. -- cwells
			$this->preview = str_replace('&#13;', '', $this->preview);
		}
		return $this->preview;
	}

}


/* Database mappings: instantiated outside the class definition because they're static. */

BlogEntry::addDatabaseMapping('Tags',
	new DatabaseMapping(DatabaseMapping::ManyToMany, 'ID', 'BlogEntry_Tag.BlogEntryID', array(
		new DatabaseMapping(DatabaseMapping::ManyToMany, 'BlogEntry_Tag.TagID', 'Tag.ID')
)));

?>
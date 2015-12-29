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

require_once 'BaseDBController.php';

class TagController extends BaseDBController
{
	/* Constructor: */
	public function __construct() {
		$this->pathInURL = \CWA\APP_ROOT . 'tags';
		$this->indexSort = 'SortOrder ASC, Value ASC';
		$this->indexLimit = 1000;
		if ($GLOBALS['app']->getCurrentUser()->hasRole('ADMIN')) {
			$this->indexClauses = "WHERE ID IN (SELECT TagID FROM BlogEntry_Tag) ORDER BY $this->indexSort";
		} else { // Do not list tags for unpublished blog entries. -- cwells
			$this->indexClauses = "WHERE ID IN (SELECT TagID FROM BlogEntry_Tag INNER JOIN BlogEntry ON BlogEntryID = BlogEntry.ID WHERE BlogEntry.Published IS NOT NULL) ORDER BY $this->indexSort";
		}
		parent::__construct();

		$this->viewInfo['view']['title'] = '{Value} :: Tags';
		$this->viewInfo['view']['description'] = 'Items tagged {Value} on ' . SITE_DOMAIN . '.';
		$this->viewInfo['view']['canonicalURL'] = PROTOCOL_HOST_PORT . "$this->pathInURL/view/{Slug}";
	}


	/* Public methods: */

	public function index() {
		parent::index();
	}

	public function view($itemID) {
		parent::view($itemID);
		$blogEntries = $this->view->getData('Item')->BlogEntries;
		if (!$this->app->getCurrentUser()->hasRole('ADMIN')) {
			for ($i = 0; $i < count($blogEntries); $i++) {
				if (is_null($blogEntries[$i]->Published)) {
					unset($blogEntries[$i]);
				}
			}
		}
		$this->view->setData('BlogEntryList', $blogEntries);
		$this->view->setData('PreviewSize', 1);
	}

}

?>
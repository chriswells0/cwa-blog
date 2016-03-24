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

use \CWA\DB\DatabaseException;
use \CWA\MVC\Controllers\InvalidArgumentException;

require_once 'BaseDBController.php';

class BlogEntryController extends BaseDBController
{
	/* Constructor */
	public function __construct() {
		$this->pathInURL = \CWA\APP_ROOT . 'blog';

		if ($GLOBALS['app']->getCurrentUser()->hasRole('ADMIN')) {
			$this->adminSort = 'Published IS NULL DESC, Published DESC';
			$this->indexSort = 'Published IS NULL DESC, Published DESC';
		} else {
			$this->indexSort = 'Published DESC';
			$this->indexClauses = "WHERE Published IS NOT NULL ORDER BY $this->indexSort";
		}

		parent::__construct();

		$this->viewInfo['add']['title'] = 'Add Blog Entry';
		$this->viewInfo['admin']['title'] = 'Blog Entry Admin';
		$this->viewInfo['admin']['description'] = 'Blog Entry Admin on ' . DOMAIN . '.';
		$this->viewInfo['edit']['title'] = 'Edit Blog Entry';
		$this->viewInfo['index']['title'] = 'Blog';
		$this->viewInfo['index']['description'] = 'Recent blog entries by '. SITE_AUTHOR . ' on ' . SITE_DOMAIN . '.';
		$this->viewInfo['page']['title'] = 'Blog - Page {PageNumber}';
		$this->viewInfo['page']['description'] = 'Older blog entries by '. SITE_AUTHOR . ' on ' . SITE_DOMAIN . '.';
		$this->viewInfo['save']['title'] = 'Save Blog Entry';
		$this->viewInfo['view']['title'] = '{Title} :: Blog';
		$this->viewInfo['view']['description'] = '{Summary}';
		$this->viewInfo['view']['canonicalURL'] = PROTOCOL_HOST_PORT . "$this->pathInURL/view/{Slug}";
	}


	/* Public methods: */

	public function add($properties = null) {
		parent::add($properties);
		$itemTagIDs = array();
		$tags = $this->db->selectAll('Tag', 'ORDER BY Value');
		if (is_null($tags)) {
			throw new DatabaseException('Error loading tags.', 500);
		}
		$this->view->setData(array('Tags' => $tags, 'BlogEntryTagIDs' => $itemTagIDs));
	}

	public function edit($itemID) {
		parent::edit($itemID);
		$tags = $this->db->selectAll('Tag', 'ORDER BY Value');
		if (is_null($tags)) {
			throw new DatabaseException('Error loading tags.', 500);
		}
		$records = $this->db->fetchAll('SELECT TagID FROM BlogEntry_Tag WHERE BlogEntryID = :BlogEntryID',
										array('BlogEntryID' => $this->view->getData('BlogEntry')->ID));
		if ($records === false) {
			throw new DatabaseException('Failed to retrieve blog entry tag IDs.', 500);
		}
		$itemTagIDs = array();
		foreach ($records as $record) {
			$itemTagIDs[] = $record['TagID'];
		}
		$this->view->setData(array('Tags' => $tags, 'BlogEntryTagIDs' => $itemTagIDs));
	}

	public function index() {
		parent::index();
	}

	public function save(array $properties) {
		if (empty($properties) || !is_array($properties)) {
			throw new InvalidArgumentException('You must provide the values to update.', 400);
		}

		// Use IsPublic to determine whether to set or clear the Published datetime. -- cwells
		if (empty($properties['IsPublic'])) { // Not published.
			$properties['Published'] = null;
		} else if ($properties['IsPublic'] === '1' && empty($properties['Published'])) { // New publish.
			$properties['Published'] = date(\CWA\DB\DATETIME_PHP_TO_DB);
		}
		unset($properties['IsPublic']); // Since it's not a real property on the object.

		// The Summary should be plain text with no double quotes. -- cwells
		$properties['Summary'] = str_replace('"', "'", strip_tags($properties['Summary']));

		parent::save($properties);
	}

	public function view($itemID) {
		parent::view($itemID);
		$matchResult = preg_match('/<img\s[^>]*src=[\'"]([^\'"]+)[\'"]/', $this->view->getData('BlogEntry')->Body, $matches);
		if ($matchResult === false || $matchResult === 0) {
			$this->view->setData(array('ImageURL' => '',
										'ImageWidth' => '',
										'ImageHeight' => ''));
		} else if (strpos($matches[1], 'http') === 0) { // Do not check dimensions of remote images. -- cwells
			$this->view->setData(array('ImageURL' => $matches[1],
										'ImageWidth' => '',
										'ImageHeight' => ''));
		} else { // Check the image dimensions. -- cwells
			$dimensions = getimagesize(preg_replace('/^(\.\.\/\.\.)?/', '../public', $matches[1]));
			$this->view->setData(array('ImageURL' => preg_replace('/^(\.\.\/\.\.)?/', PROTOCOL_HOST_PORT, $matches[1]),
										'ImageWidth' => $dimensions[0],
										'ImageHeight' => $dimensions[1]));
		}
	}

}

?>
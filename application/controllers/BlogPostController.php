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

class BlogPostController extends BaseDBController
{
	/* Constructor */
	public function __construct() {
		$this->adminSort = 'Published IS NULL DESC, Published DESC';
		$this->indexSort = 'Published DESC';
		$this->indexClauses = "WHERE Published IS NOT NULL ORDER BY $this->indexSort";

		parent::__construct();

		$this->viewInfo['add']['title'] = 'Add Blog Post';
		$this->viewInfo['admin']['title'] = 'Blog Admin';
		$this->viewInfo['admin']['description'] = 'Blog Admin on ' . DOMAIN . '.';
		$this->viewInfo['edit']['title'] = 'Edit Blog Post';
		$this->viewInfo['index']['title'] = 'Blog';
		$this->viewInfo['index']['description'] = 'Recent blog posts by '. SITE_AUTHOR . ' on ' . SITE_DOMAIN . '.';
		$this->viewInfo['page']['title'] = 'Blog - Page {PageNumber}';
		$this->viewInfo['page']['description'] = 'Older blog posts by '. SITE_AUTHOR . ' on ' . SITE_DOMAIN . '.';
		$this->viewInfo['save']['title'] = 'Save Blog Post';
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
		$this->view->setData(array('Tags' => $tags, 'BlogPostTagIDs' => $itemTagIDs));
	}

	public function edit($itemID) {
		parent::edit($itemID);
		$tags = $this->db->selectAll('Tag', 'ORDER BY Value');
		if (is_null($tags)) {
			throw new DatabaseException('Error loading tags.', 500);
		}
		$records = $this->db->fetchAll('SELECT TagID FROM BlogPost_Tag WHERE BlogPostID = :BlogPostID',
										array('BlogPostID' => $this->view->getData('BlogPost')->ID));
		if ($records === false) {
			throw new DatabaseException('Failed to retrieve blog post tag IDs.', 500);
		}
		$itemTagIDs = array();
		foreach ($records as $record) {
			$itemTagIDs[] = $record['TagID'];
		}
		try {
			require_once \CWA\LIB_PATH . 'cwa/io/FileManager.php';
			$fileManager = new \CWA\IO\FileManager("../public/images$this->pathInURL");
			$slug = $this->view->getData('BlogPost')->Slug;
			$images = $fileManager->getDirectoryListing("$slug[0]/$slug")->Files;
		} catch (Exception $ex) {
			$images = array();
		}
		$this->view->setData(array('BlogPostTagIDs' => $itemTagIDs,
									'Images' => $images,
									'Tags' => $tags));
	}

	public function image(array &$properties) {
		if (empty($properties)) {
			throw new InvalidArgumentException('You must provide the values to update.', 400);
		} else if (isset($properties['itemID'])) {
			// itemID is the only parameter passed for deletions. -- cwells
			$properties['action'] = 'delete';
		} else if (!isset($properties['action']) || empty($properties['action'])) {
			throw new InvalidArgumentException('You must specify the action to perform.', 400);
		} else if (!isset($properties['Path']) || empty($properties['Path'])) {
			throw new InvalidArgumentException('You must provide a path.', 400);
		}

		require_once \CWA\LIB_PATH . 'cwa/io/FileManager.php';
		$fileManager = new \CWA\IO\FileManager("../public/images$this->pathInURL");
		$action = $properties['action'];
		$this->loadView('image');
		if ($action === 'add') {
			$fileWasProvided = (isset($_FILES['image']) && !empty($_FILES['image']) && !empty($_FILES['image']['name']));
			if (!$fileWasProvided) {
				throw new InvalidArgumentException('You must provide a file to upload.', 400);
			}

			$path = (empty($properties['Path']) ? '' : $properties['Path'] . DIRECTORY_SEPARATOR);
			if (!$fileManager->isDirectory($path)) {
				if (!$fileManager->isDirectory(dirname($path))) {
					$fileManager->mkdir(dirname($path)); // Error check happens below. -- cwells
				}
				if (!$fileManager->mkdir($path)) {
					$this->view->setStatus('Failed to create the image directory.', 500);
					return;
				}
			}
			if ($fileManager->saveUploadedFile($_FILES['image'], $path . $_FILES['image']['name'])) {
				$itemID = (empty($properties['Path']) ? '' : $properties['Path'] . '/') . $_FILES['image']['name'];
				$file = $fileManager->getFileInfo($itemID);
				if (isset($file) && preg_match('/^(gif|jpe?g|png|tiff?)$/i', $file->getExtension()) !== 1) {
					$fileManager->delete($itemID);
					throw new InvalidArgumentException('Only images may be uploaded.', 400);
				}

				$this->view->setData(array('ModelType' => 'File',
											'File' => $file));
				$this->view->setStatus('Successfully saved the uploaded file.');
			} else {
				$this->view->setStatus('Failed to save the uploaded file.', 500);
			}
		} else if ($action === 'edit') {
			$oldPath = $properties['Path'];
			$parentDir = dirname($oldPath);
			$newPath = ($parentDir === '.' ? '' : $parentDir . DIRECTORY_SEPARATOR) . $properties['Name'];
			if ($fileManager->rename($oldPath, $newPath)) {
				$itemID = ($parentDir === '.' ? '' : $parentDir . '/') . $properties['Name'];
				$file = $fileManager->getFileInfo($itemID);
				$this->view->setData(array('ModelType' => 'File',
											'File' => $file));
				$this->view->setStatus('Successfully renamed the specified file.');
			} else {
				$this->view->setStatus('Failed to rename the specified file.', 500);
			}
		} else if ($action === 'delete') {
			if (empty($properties['itemID'])) {
				throw new InvalidArgumentException('You must specify the item to delete.', 400);
			}

			if ($fileManager->delete($properties['itemID'])) {
				$this->view->setStatus('Successfully deleted the specified item.');
			} else {
				$this->view->setStatus('Error deleting the specified item.', 500);
			}
		} else {
			throw new InvalidArgumentException('You have specified an invalid action.', 400);
		}
	}

	public function index() {
		parent::index();
	}

	public function save(array &$properties) {
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

		// If this is an existing blog post and the slug changed, move associated images. -- cwells
		if (!empty($properties['ID']) && $properties['OldSlug'] !== $properties['Slug']) {
			require_once \CWA\LIB_PATH . 'cwa/io/FileManager.php';
			$fileManager = new \CWA\IO\FileManager("../public/images$this->pathInURL");
			$oldPath = $properties['OldSlug'][0] . '/' . $properties['OldSlug'];
			$newPath = $properties['Slug'][0] . '/' . $properties['Slug'];
			if ($fileManager->isDirectory($oldPath)) {
				if (!$fileManager->isDirectory(dirname($newPath))) {
					$fileManager->mkdir(dirname($newPath)); // Error check happens below. -- cwells
				}
				if (!$fileManager->rename($oldPath, $newPath)) {
					throw new InvalidArgumentException('Failed to rename the image directory.', 500);
				}
				// Update any URLs that refer to the old path in the content. -- cwells
				$properties['Body'] = str_replace("/images$this->pathInURL/$oldPath/", "/images$this->pathInURL/$newPath/", $properties['Body']);
			}
		}
		unset($properties['OldSlug']);

		parent::save($properties);
	}

	public function view($itemID) {
		parent::view($itemID);
		$matchResult = preg_match('/<img\s[^>]*src=[\'"]([^\'"]+)[\'"]/', $this->view->getData('BlogPost')->Body, $matches);
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
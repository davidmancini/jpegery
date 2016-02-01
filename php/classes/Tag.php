<?php
/**
 * Tag is the hashtag that can be assigned to an image
 *
 * Tags are the primary method of sorting out pictures for users.
 * Users can search tags and assign them to their own images
 * so that other users may find them. Tags will also be used
 * to rank the popularity of a given image.
 *
 * @authors David Mancini, Jacob Findley, Michael Kemm, Zach Leyba
 *

 **/

class Tag {
	/**ID# of a given tag
	 * @var int $tagId
	 */

	private $tagId;

	/** Name of the tag
	 * @var string $tagName
	 **/

	private $tagName;

	/**
	 * constructor for this item
	 *
	 * @param int $newTagId id of this Tag or null if a new Tag
	 * @param string $newTagName name of a given tag
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct(int $newTagId, string $newTagName) {
	}
}



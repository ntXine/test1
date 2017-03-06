<?php

namespace frontend\modules\catalogUpdater\interfaces;

use yii\web\UploadedFile;

/**
 * Interface ICatalogUpdatePostForm common interface to update post form
 * @package frontend\modules\catalogUpdater\interfaces
 */
interface ICatalogUpdatePostForm
{
	public function getCategoryDepth(): int;

	public function getFileInstance(): UploadedFile;

	public function getColumns(): string;

	public function getMimeType(): string;
}
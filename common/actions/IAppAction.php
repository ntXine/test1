<?php

namespace common\actions;

/**
 * Interface IAppAction common interface to some business logic actions
 * @package common\actions
 */
interface IAppAction
{
	const ACTION_SUCCESS = true;
	const ACTION_FAIL = false;

	public function run(): bool;

	public function getMessages(): array;

	public function getStatus(): string;
}
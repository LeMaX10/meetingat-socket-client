<?php
/**
 * Created by PhpStorm.
 * User: api
 * Date: 20.07.16
 * Time: 10:00
 */

namespace LeMaX10\MeetingatSocketClient\methods;


use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

class ImageMethod implements MethodInterface
{
	use MethodTrait;

	public function get(int $userId)
	{
		return $this->send(SendTypeEnum::GET, 'images/:userId', ['params' => ['userId' => $userId]]);
	}

	public function create(array $arguments = [])
	{
		return $this->send(SendTypeEnum::POST, 'images', $arguments);
	}

	public function update(int $userId, array $arguments = [])
	{
		return $this->send(SendTypeEnum::PUT, 'images/:userId', ['params' => ['userId' => $userId], 'body' => $arguments]);
	}

	public function delete(int $userId)
	{
		return $this->send(SendTypeEnum::DELETE, 'images/:userId', ['params' => ['userId' => $userId]]);
	}

	public function checkAndUpdateOrDelete($userModel)
	{
		$findImage = $this->get($userModel->id);
		if($findImage) {
			if (!$userModel->avatar) {
				$this->delete($userModel->id);
				return;
			}

			$attributes = [
				'user_id' => $userModel->id,
				'image_id' => $userModel->avatar->id,
				'link' => $userModel->avatar->link
			];

			if($findImage->code == 404) {
				$this->create($attributes);
			} else if ($findImage->code == 200) {
				$this->update($userModel->id, $attributes);
			}
		}
	}
}
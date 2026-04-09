<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class AddBaseSettings
 */
class AddBaseSettings extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach ([
					 [
						 'name' => 'Email компании',
						 'code' => 'companyEmail',
						 'value' => '',
						 'description' => 'This email address will be shown in contacts and all form requests will be sent to it.',
					 ],
					 [
						 'name' => 'Телефон компании',
						 'code' => 'companyPhone',
						 'value' => '',
						 'description' => 'This email address will be shown in contacts and all form requests will be sent to it.',
					 ],
					 [
						 'name' => 'Код сайта в comagic',
						 'code' => 'comagicSiteID',
						 'value' => '',
						 'description' => 'Код сайта в comagic, указываемый при подключении скриптов.',
					 ],
				 ] as $settingArr) {
			$setting = new \App\Models\System\Setting();
			$setting->name = $settingArr['name'];
			$setting->code = $settingArr['code'];
			$setting->value = $settingArr['value'];
			$setting->description = $settingArr['description'];
			$setting->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}

<?php
namespace App\Policies;

use Spatie\Csp\Directive;

class AmazonS3Policy extends Base
{
	public function configure() {
		parent::configure();
		
		$this->addDirective(Directive::IMG, "self data: infosec-project.s3.ap-northeast-1.amazonaws.com")
			->addDirective(Directive::MEDIA, "self data: infosec-project.s3.ap-northeast-1.amazonaws.com");
	}
}
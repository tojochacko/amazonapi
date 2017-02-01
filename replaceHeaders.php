<?php

include_once('amazon_s3_client.class.php');

$bucket_name = '*** bucket name ***';
$awsS3 = new AmazonS3($bucket_name);
$awsS3->updateHeaders();

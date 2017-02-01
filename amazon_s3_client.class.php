<?php
require 'AWSSDK/aws-autoloader.php';

use Aws\S3\S3Client; 

class AmazonS3 
{
    public $bucket;
    public $client;

    public function __construct($bucketName) 
    {
        // Instantiate the S3 client using your credential profile
        $s3Client = S3Client::factory(array(
            'key' => '*** key name ***',
            'secret' => '*** secret name ***',
        ));

        $this->client = $s3Client;
        $this->bucket = $bucketName;
        $this->marker = null;
        $this->MAX_KEYS = 200;
    }

    public function updateHeaders() {
        $iterator = $this->client->getIterator('ListObjects', array(
            'Bucket' => $this->bucket,
            'Prefix' => '*** folder name ***'
        ));

        foreach ($iterator as $object) {
            echo $object['Key']."\n";                
            $sourceBucket = $this->bucket;
            $sourceKeyname = $object['Key'];
            $targetBucket = $this->bucket //i m replacing the same item in the same bucket;

            // Copy an object, replace header meta information
            $this->client->copyObject(array(
                'Bucket'     => $targetBucket,
                'Key'        => "{$sourceKeyname}",
                'CopySource' => "{$sourceBucket}/{$sourceKeyname}",
                'ACL' => 'public-read',
                'MetadataDirective' => 'REPLACE',
                'ContentType' => 'text/html'
            ));
        }
    }
}

?>

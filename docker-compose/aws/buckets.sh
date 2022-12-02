set -x
awslocal s3 mb s3://bucket
awslocal s3api put-bucket-acl --bucket bucket --acl public-read
set +x

#!/bin/bash

echo
echo "Setting the default AWS region..."
az=$(curl http://169.254.169.254/latest/meta-data/placement/availability-zone)
region=${az%?}
export AWS_DEFAULT_REGION=$region
echo "Region =" $AWS_DEFAULT_REGION
#
# Set the application parameter values.
#
publicDNS=$(curl http://169.254.169.254/latest/meta-data/public-hostname)
echo "Public DNS =" $publicDNS
echo
echo "Setting the application parameter values in the Parameter Store..."
aws ssm put-parameter --name "/shop/showServerInfo" --type "String" --value "false" --description "Show Server Information Flag" --overwrite
aws ssm put-parameter --name "/shop/timeZone" --type "String" --value "Europe/Dublin" --description "Time Zone" --overwrite
aws ssm put-parameter --name "/shop/currency" --type "String" --value "€" --description "Currency Symbol" --overwrite
aws ssm put-parameter --name "/shop/dbUrl" --type "String" --value $publicDNS --description "Database URL" --overwrite
aws ssm put-parameter --name "/shop/dbName" --type "String" --value "shop_db" --description "Database Name" --overwrite
aws ssm put-parameter --name "/shop/dbUser" --type "String" --value "root" --description "Database User Name" --overwrite
aws ssm put-parameter --name "/shop/dbPassword" --type "String" --value "Re:Start!9" --description "Database Password" --overwrite

echo
echo "Application Parameter Setup script completed."
echo

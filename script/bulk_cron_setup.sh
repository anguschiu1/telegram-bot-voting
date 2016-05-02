rm ~/app-root/runtime/repo/.openshift/cron/hourly/*
rm ~/app-root/runtime/repo/.openshift/cron/minutely/*
cp bulk_cron.sh ~/app-root/runtime/repo/.openshift/cron/hourly/
#cp bulk_cron.sh ~/app-root/runtime/repo/.openshift/cron/minutely/
echo "Hourly"
ls -l ~/app-root/runtime/repo/.openshift/cron/hourly/
echo "Minutely"
ls -l ~/app-root/runtime/repo/.openshift/cron/minutely/

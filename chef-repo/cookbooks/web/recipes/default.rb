#
# Cookbook:: web
# Recipe:: default
#
# Copyright:: 2018, The Authors, All Rights Reserved.

yum_package "yum-fastestmirror" do
  action :install
end

execute "yum-update" do
  user "root"
  command "yum -y update"
  action :run
end


# install epel
package 'epel-release.noarch' do
  action [:install, :upgrade]
end

# remi-release-7
remote_file "#{Chef::Config[:file_cache_path]}/remi-release-7.rpm" do
    source "http://rpms.famillecollet.com/enterprise/remi-release-7.rpm"
    not_if "rpm -qa | grep -q '^remi-release'"
    action :create
    # notifies :install, "rpm_package[remi-release]", :immediately
end

# remi-release-7
rpm_package 'remi-release-7' do
  not_if "rpm -qa | grep -q '^remi-release'"
  source "#{Chef::Config[:file_cache_path]}/remi-release-7.rpm"
  action [:install, :upgrade]
end

%w(php nginx php-openssl php-common php-mbstring php-xml php-pdo php-mbstring php-fpm php-gd).each do |pkg|
  package pkg do
    flush_cache [:before]
    action [:install, :upgrade]
    options "--enablerepo=remi-php56"
  end
end

directory "/vagrant/public" do
  action :create
  owner 'vagrant'
  group 'vagrant'
end

service 'nginx' do
  action [:enable, :start]
  #supports status: true, restart: true, reload: true
end

service "php-fpm" do
  action [:enable, :start]
end

template '/etc/nginx/nginx.conf' do
  source 'nginx.conf.erb'
  owner 'root'
  group 'root'
  mode 0644
  notifies :reload, 'service[nginx]'
  notifies :reload, 'service[php-fpm]'
end

template '/etc/php-fpm.d/www.conf' do
  source 'www.conf.erb'
  owner 'root'
  group 'root'
  mode '0644'
  notifies :reload, 'service[nginx]'
  notifies :reload, 'service[php-fpm]'
end

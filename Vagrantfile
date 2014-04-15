# -*- mode: ruby -*-
# vi: set ft=ruby :

HOSTNAME = "d8training.lo"
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "precise64"
  config.vm.box_url = "http://transfer.amazeelabs.com/vagrant/precise64.box"
  config.vm.hostname = HOSTNAME
  config.hostsupdater.aliases = ["xhprof." + HOSTNAME]
  config.vm.network :private_network, :ip => '192.168.111.42'
  config.ssh.forward_agent = true
  config.vm.synced_folder ".", "/home/vagrant/public_html" , :nfs => true

  config.vm.provider :virtualbox do |vm|
    vm.customize ["modifyvm", :id, "--memory", "512"]
  end

  config.vm.provision :chef_solo do |chef|
    chef.cookbooks_path = "vagrant"
    chef.log_level = ENV['CHEF_LOG'] || "info"

    chef.json = {
        ":hostname" => HOSTNAME
    }

    chef.add_recipe("common")
    chef.add_recipe("php::php54")
    chef.add_recipe("php::php-additions")
    chef.add_recipe("xhprof")
    chef.add_recipe("composer")
    chef.add_recipe("drush")
    chef.add_recipe("drush::deploy")
    chef.add_recipe("drupal::drupal-settings")
    chef.add_recipe("drupal::mysql-database")
  end
end

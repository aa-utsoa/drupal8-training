bash "Import Database" do
  user "root" # see attributes section below
  code <<-EOH
    echo "source /home/vagrant/public_html/assets/vanilla-drupal8/drupal_20140415_113317.sql" | mysql --database=drupal
    EOH
end

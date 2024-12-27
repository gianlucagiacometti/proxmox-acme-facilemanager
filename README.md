# proxmox-acme-facilemanager
Script hooks for acme.sh, ProxMox and facileManager DNS

NOTE:
At the moment, all changes must be done manually. I opened a pull request to add dns_fmdns.sh to acme.sh official repository, and I opened a pull request for some changes in facileManager required to perform automated dns record updates.

## Steps to install:

### 1. Set up facileManager API client

Place dnsapi.php in the same server of facileManager client (where the file client.php resides). The file must be rachable via https by your ProxMox hosts, and I suggest to create a dedicated domain for the purpose (i.e. https://my-fm-api-server.com/dnsapi.php).

Place dnsapi.sh in the same server, OUTSIDE any public folder of the web server.

Modify dnsapi.sh with the correct path to your facileManager client.php.

Add this line to /etc/sudoers:
```
www-data  ALL=(root) NOPASSWD: /path/to/my/scripts/dnsapi.sh
```

### 2. Set up ProxMox for facileManager API

Place the script dns_fmdns.sh in /usr/share/proxmox-acme/dnsapi/ (owner root:root, mod: 0644) of every host of the cluster.

Modify usr/share/proxmox-acme/dns-challenge-schema.json according to the file dns-challenge-schema.diff (actually you can add the fmdns json record in any acceptable position of the json object.

Run:
```
systemctl restart pveproxy
systemctl restart pvedaemon
```

Now you should be able to find "facileManager DNS API" in the list of ProxMox ACME DNS plugins.

I suggest to set a delay value of at least 360s, since since facileManager updates dns zones usually every 300s (I use 600 to avoid problems with dns propagation).

Have a nice day :-)

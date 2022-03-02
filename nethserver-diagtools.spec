Summary: NethServer diagnostic tools
Name: nethserver-diagtools
Version: 1.0.3
Release: 1%{?dist}
License: GPL
Source: %{name}-%{version}.tar.gz
BuildArch: noarch
URL: %{url_prefix}/%{name}
BuildRequires: nethserver-devtools
Requires: arp-scan
Requires: speedtest-cli
Requires: perl-LWP-Protocol-https

%description
NethServer diagnostic tool
%prep
%setup

%post
%preun

%build
%{makedocs}
perl createlinks

%install
rm -rf $RPM_BUILD_ROOT
(cd root   ; find . -depth -print | cpio -dump $RPM_BUILD_ROOT)

%{genfilelist} %{buildroot} \
  --file /etc/cron.monthly/UpdateArpScanVendors 'attr(0750,root,root)' \
$RPM_BUILD_ROOT > e-smith-%{version}-filelist

%clean
rm -rf $RPM_BUILD_ROOT

%files -f e-smith-%{version}-filelist
%doc COPYING
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update

%changelog
* Thu Nov 08 2018 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.3-1
- Quiet the get-oui and get-iab cron job - NethServer/dev#5617

* Wed May 30 2018 Stephane de Labrusse <stephdl@de-labrusse.fr> - 1.0.2-1
- Automated RPM builds - NethServer/dev#5393 
- Speedtest: Usage of bad IP - Bug NethServer/dev#5510

* Mon Oct 23 2017 Davide Principi <davide.principi@nethesis.it> - 1.0.1-1
- Translation of the Server ID -- stephdl/nethserver-diagtools#1

* Fri Oct 06 2017 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.0-1
- Add speedtest
- First release for NS 7.4

* Wed Oct 04 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.9-1-ns7
- Added speedtest-cli

* Thu Mar 02 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.8-1-ns7
- Added copyright and GPLV3 License.

* Wed Feb 15 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.7-1-ns7
- arp-scan used to scan blue interfaces
- update vendors monthly

* Tue Feb 14 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.6-1-ns7
- arp-scan used to scan green interfaces

* Wed Jan 4 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.5-1-ns7
- sudo removed, except for traceroute

* Tue Jan 3 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.4-1-ns7
- Mail tab, Internet IP tab, stderr is displayed in tab (NSlookup,Ping,Traceroute)

* Fri Dec 30 2016 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.3-1-ns7
- First release to NS7

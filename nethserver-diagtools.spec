Summary: NethServer diagnostic tools
%define name nethserver-diagtools
%define version 0.0.6
%define release 1
Name: %{name}
Version: %{version}
Release: %{release}%{?dist}
License: GPL
Source: %{name}-%{version}.tar.gz
BuildArch: noarch
URL: http://dev.nethserver.org/projects/nethforge/wiki/%{name}
BuildRequires: nethserver-devtools
Requires: arp-scan
#AutoReq: no

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
$RPM_BUILD_ROOT > e-smith-%{version}-filelist

%clean
rm -rf $RPM_BUILD_ROOT

%files -f e-smith-%{version}-filelist
%defattr(-,root,root)

%dir %{_nseventsdir}/%{name}-update

%changelog
* Tue Feb 14 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.6-1-ns7
- arp-scan used to scan green interfaces

* Wed Jan 4 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.5-1-ns7
- sudo removed, except for traceroute

* Tue Jan 3 2017 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.4-1-ns7
- Mail tab, Internet IP tab, stderr is displayed in tab (NSlookup,Ping,Traceroute)

* Fri Dec 30 2016 Stephane de Labrusse <stephdl@de-labrusse.fr> - 0.0.3-1-ns7
- First release to NS7

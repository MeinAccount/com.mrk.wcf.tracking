com.mrk.wcf.tracking - Tracking for the WCF
====================

A package adding tracking functionality to the [WoltLab Community Framework 2.0](https://github.com/WoltLab/WCF).

Functions
---------

* Management of tracking providers
* Automatic compression of tracking code
* Page for opt-out of tracking
* Goal / Conversions tracking API

Supported tracking providers
----------------------------
Feel free to create a pull request adding any tracking providers you need.

* Piwik
* @todo Google Analytics

Why don't use the footer-code option?
-------------------------------------
This package contains an easy to use API for tracking goals / conversions. For example tracking whether an user has registered is only one click away.
Additionally the management of multiple tracking providers is a lot easier. Admins (or any user group you want for that matter) are excluded from 
the tracking by default.

License
-------

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public License
as published by the Free Software Foundation; either version 2.1
of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

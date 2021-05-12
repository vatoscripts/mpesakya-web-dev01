@isset($user)
    <nav class="sidebar" data-sidebar-anyclick-close>
        <!-- START sidebar nav-->
        <ul class="sidebar-nav">
            <li class="nav-heading">
                <span data-localize="sidebar.heading.HEADER">Main Navigation</span>
            </li>

            <li class>
                <router-link to="/home">
                <em class="icon-speedometer"></em>
                <span data-localize="sidebar.nav.DASHBOARD">Dashboard</span>
                </router-link>
            </li>

            @if ($user['Role'] === 6 || $user['Role'] === 7 || $user['Role'] === 8 )
                <li class>
                    <a href="#Aggregator" title="Layouts" data-toggle="collapse">
                    <em class="icon-grid"></em>
                    <span>Aggregator</span>
                    </a>
                    <ul class="sidebar-nav sidebar-subnav collapse" id="Aggregator">
                    <li class="sidebar-subnav-header">Aggregator</li>
                    <li class>
                        <router-link to="/aggregator/onboard-nida">
                        <span>Onboard Aggregator</span>
                        </router-link>
                    </li>
                    <li class>
                        <router-link to="/aggregator/all">
                        <span>View All</span>
                        </router-link>
                    </li>
                    </ul>
                </li>

                <li class>
                    <a href="#Wakala-verification" title="Layouts" data-toggle="collapse">
                    <em class="icon-note"></em>
                    <span>Wakala Verification</span>
                    </a>
                    <ul class="sidebar-nav sidebar-subnav collapse" id="Wakala-verification">
                        <li class="sidebar-subnav-header">Wakala Verification</li>

                        <li class>
                            <router-link to="/wakala/unverified">
                            <span>Unverified Wakala</span>
                            </router-link>
                        </li>
                        <li class>
                            <router-link to="/wakala/approved">
                                <span>Approved Wakala</span>
                            </router-link>
                        </li>
                        <li class>
                            <router-link to="/wakala/declined">
                                <span>Declined Wakala</span>
                            </router-link>
                        </li>
                        <li class>
                            <router-link to="/wakala/status">
                                <span>Wakala with Status</span>
                            </router-link>
                        </li>

                    </ul>
                </li>

                <li class>
                    <router-link to="/reports">
                    <em class="icon-graph"></em>
                    <span data-localize="sidebar.nav.DASHBOARD">Reports</span>
                    </router-link>
                </li>
            @endif

            @if ($user['Role'] === 1 || $user['Role'] === 5 || $user['Role'] === 4)
                <li class>
                    <a href="#Wakala" title="Layouts" data-toggle="collapse">
                    <em class="icon-cursor"></em>
                    <span>Wakala</span>
                    </a>
                    <ul class="sidebar-nav sidebar-subnav collapse" id="Wakala">
                        <li class="sidebar-subnav-header">Wakala</li>
                        <li >
                            <router-link to="/wakala/onboard-contract">
                                <span>Onboard Wakala</span>
                            </router-link>
                        </li>
                        @if ($user['Role'] !== 5)
                           <li >
                                <router-link to="/recruiter/onboard">
                                <span>Onboard Recruiter</span>
                                </router-link>
                            </li>

                            <li >
                                <router-link to="/wakala/all">
                                <span>View All Wakala</span>
                                </router-link>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif
        </ul>
        <!-- END sidebar nav-->
    </nav>
@endisset

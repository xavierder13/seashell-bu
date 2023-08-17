<template>
  <v-app>
    <!-- Navbar -->
    <v-app-bar dense dark app>
      <v-btn icon @click.stop="drawer = !drawer">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
      </v-btn>
      <v-spacer></v-spacer>

      <v-menu offset-y :nudge-width="200">
        <template v-slot:activator="{ on, attrs }">
          <v-btn small rounded v-bind="attrs" v-on="on" color="grey darken-3">
            <v-icon> mdi-menu-down </v-icon>
          </v-btn>
        </template>
        <v-card color="grey lighten-3">
          <v-card-text class="text-center">
            <v-row>
              <v-col
                ><img
                  src="/img/default-profile.png"
                  width="120px"
                  height="100px"
                  alt="User"
                  style="border-radius: 50%"
              /></v-col>
            </v-row>
            <v-row>
              <v-col>
                <h5 class="text--secondary">
                  {{ user.name }}
                </h5>
                <h6 class="text--disabled">
                  {{
                    user.id === 1
                      ? "Administrator"
                      : user.position
                      ? user.position.name
                      : ""
                  }}
                </h6>
              </v-col>
            </v-row>
          </v-card-text>
          <v-divider class="pa-0 mb-0"></v-divider>
          <v-card-actions class="grey darken-2 d-flex justify-content-around">
            <div>
              <v-btn class="white--text" plain small @click="userProfile()">
                <v-icon small class="mr-1">mdi-account</v-icon> Profile
              </v-btn>
            </div>
            <div>
              <v-btn class="white--text" plain small @click="confirmLogout()">
                <v-icon small class="mr-1">mdi-logout</v-icon> Logout
              </v-btn>
            </div>
          </v-card-actions>
        </v-card>
      </v-menu>
    </v-app-bar>

    <!-- Sidebar -->
    <v-navigation-drawer v-model="drawer" dark app>
      <v-list>
        <v-list-item class="px-2">
          <v-list-item-avatar class="rounded-5" height="60" width="60">
            <v-img src="/img/default-profile.png"></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>BINTAN SEASHELLS</v-list-item-title>
            <v-list-item-subtitle>{{ user.name }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-list dense class="pt-0">
        <template v-for=" (menu, index) in menuList " v-if="menu.hasPermission">
          <v-divider></v-divider>
          <span class="subtitle-2 font-weight-bold ml-4 blue--text text--lighten-4"> 
            {{ menu.group_header_title }} 
          </span>
  
          <template v-for=" (list, i) in menu.list_items ">
            <v-list-group
              :class="i === 0 ? 'mt-2' : ''"
              no-action
              v-if="list.children.length && list.hasPermission"
            >
              <template v-slot:activator>
                <v-list-item-content>
                  <v-list-item-title>
                    <v-icon class="mr-2">{{ list.icon }}</v-icon>
                    {{ list.title }}
                  </v-list-item-title>
                </v-list-item-content>
              </template>
              <template v-for=" child in list.children ">
                <v-list-item
                  link
                  :to="child.link"
                  v-if="child.hasPermission"
                >
                  <v-list-item-content>
                    <v-list-item-title>{{ child.title }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-list-group>
            <v-list-item
              :class="i === 0 ? 'mt-2' : ''"
              @click="callMethod(list.method)"
              link
              :to="list.link"
              v-if="!list.children.length && list.hasPermission"
            >
              <v-list-item-content >
                <v-list-item-title> 
                  <v-icon class="mr-2">{{ list.icon }}</v-icon>
                  {{ list.title }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-overlay :absolute="absolute" :value="overlay">
      <v-progress-circular
        :size="70"
        :width="7"
        color="primary"
        indeterminate
      ></v-progress-circular>
    </v-overlay>
    <!-- Content -->
    <router-view />

    <v-footer padless dense dark app>
      <v-col class="text-center" cols="12">
        Copyright © {{ new Date().getFullYear() }} —
        <strong> BINTAN SEASHELLS</strong>
      </v-col>
    </v-footer>
  </v-app>
</template>

<style>
  html { overflow-y: auto !important } /* show scrollbar when overflow */
</style>

<script>

import axios from "axios";
import { mapState, mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      absolute: true,
      overlay: false,
      drawer: true,
      mini: false,
      right: null,
      selectedItem: 1,
      loading: null,
      initiated: false,
    };
  },

  methods: {
    userProfile() {
      this.$router.push({ name: "user.profile" }).catch((e) => {});
    },
    logout() {
      this.overlay = true;
      axios.get("/api/auth/logout").then(
        (response) => {
          if (response.data.success) {
            this.overlay = false;

            // remove all local storage including access_token
            window.localStorage.clear();
            this.$router.push("/login").catch(() => {});
          }
        },
        (error) => {
          this.overlay = false;
          console.log(error);

          // if unauthenticated (401)
          if (error.response.status == "401") {

            // remove all local storage including access_token
            window.localStorage.clear();
            this.$router.push({ name: "login" });
          }
        }
      );
    },

    confirmLogout() {
      
      this.$swal({
        title: "Log Out",
        text: "Are you sure you want to log out?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "primary",
        cancelButtonColor: "secondary",
        confirmButtonText: "Log Out",
      }).then((result) => {
        
        if (result.value) {
          this.overlay = true;
          this.logout();
        }
        
      });

    },
    callMethod(name){
      name ? this[name]() : '';
    },
    ...mapActions("auth", ["getUser"]),
    ...mapActions("userRolesPermissions", ["userRolesPermissions"]),

  },

  computed: {
    menuList() {
      
      let menu = [
        { // START Dashboard
          group_header_title: 'Dashboard',
          hasPermission: true,
          list_items: [
            {
              title: 'Dashboard',
              icon: 'mdi-view-dashboard',
              link: '/dashboard',
              method: '',
              hasPermission: true,
              children: [],
            },
          ]
        }, // END Dashboard

        { // START Dashboard
          group_header_title: 'Dashboard',
          hasPermission: false,
          list_items: [
            {
              title: 'Species',
              icon: 'mdi-file',
              link: '/species/index',
              method: '',
              hasPermission: this.hasPermission('species-list'),
              children: [],
            },
          ]
        }, // END Dashboard
        
        { // START Set Up & Athorization group menu
          group_header_title: 'Set Up & Authorizations',
          hasPermission: false,
          list_items: [
            {
              title: 'User Management',
              icon: 'mdi-account-arrow-right-outline',
              link: '',
              method: '',
              hasPermission: false,
              children: [
                { 
                  title: 'User Accounts',
                  link: '/user/index',
                  hasPermission: this.hasPermission('user-list'),
                },
                { 
                  title: 'Create New',
                  link: '/user/create',
                  hasPermission: this.hasPermission('user-create'),
                },
              ],
            },
            {
              title: 'Access Chart',
              icon: 'mdi-chart-arc',
              link: '',
              method: '',
              hasPermission: false,
              children: [
                { 
                  title: 'Access Chart Lists',
                  link: '/access_chart/index',
                  hasPermission: this.hasPermission('access-chart-list'),
                },
                { 
                  title: 'Access Module Lists',
                  link: '/access_module/index',
                  hasPermission: this.hasAnyPermission('access-module-list', 'access-module-create'),
                },
                { 
                  title: 'Access Level',
                  link: '/access_level',
                  hasPermission: this.hasPermission('access-level-edit'),
                },
              ],
            },
            {
              title: 'Settings',
              icon: 'mdi-cog',
              link: '',
              method: '',
              hasPermission: false,
              children: [
                { 
                  title: 'Branch',
                  link: '/branch/index',
                  hasPermission: this.hasAnyPermission('branch-list', 'branch-create'),
                },
                { 
                  title: 'Company',
                  link: '/company/index',
                  hasPermission: this.hasAnyPermission('company-list', 'company-create'),
                },
                { 
                  title: 'Position',
                  link: '/position/index',
                  hasPermission: this.hasAnyPermission('position-list', 'position-create'),
                },
                { 
                  title: 'Department',
                  link: '/department/index',
                  hasPermission: this.hasAnyPermission('department-list', 'department-create'),
                },
                { 
                  title: 'Role',
                  link: '/role/index',
                  hasPermission: this.hasAnyPermission('role-list', 'role-create'),
                },
                { 
                  title: 'Permission',
                  link: '/permission/index',
                  hasPermission: this.hasAnyPermission('permission-list', 'permission-create'),
                },
              ],
            },
          ],
        }, // END Set Up & Athorization group menu
        
      ];

      menu.forEach(item => {
        item.list_items.forEach(list => {

          list.children.forEach(child => {
            if(child.hasPermission)
            {
              list.hasPermission = true;
            }
          }); 

          if(list.hasPermission)
          {
            item.hasPermission = true;
          }

        });
      });
      return menu;
    },
    ...mapState("auth", ["user"]),
    ...mapGetters("userRolesPermissions", ["hasRole", "hasAnyRole", "hasPermission", "hasAnyPermission"]),
  },
  watch: {
    isIdle(){
      // if (this.isIdle) {
      //   this.sessionExpiredSwal();
      // }
    }
  },

  mounted() {
    axios.defaults.headers.common["Authorization"] =
      "Bearer " + localStorage.getItem("access_token");
    this.userRolesPermissions();
    this.getUser();

  },
};
</script>
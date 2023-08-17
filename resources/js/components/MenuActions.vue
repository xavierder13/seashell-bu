<template>
  <div 
    class="d-flex justify-content-end mb-3" 
    v-if="menu.hasPermission"
  >
    <v-menu offset-y :close-on-content-click="false">
      <template v-slot:activator="{ on, attrs }">
        <v-btn small v-bind="attrs" v-on="on" color="primary">
          Actions
          <v-icon small> mdi-menu-down </v-icon>
        </v-btn>
      </template>
      <v-list class="pa-1">
        <template v-for="list in menu.list">
          <v-list-item
            class="ma-0 pa-0"
            style="min-height: 25px"
            v-if="list.hasPermission"
          >
            <v-list-item-title>
              <v-btn
                class="mx-1 white--text"
                :color="list.color"
                width="100px"
                x-small
                @click="callMethod(list.method)"
              >
                <v-icon class="mr-1" x-small> {{ list.icon }} </v-icon>
                {{ list.text }}
              </v-btn>
            </v-list-item-title>
          </v-list-item>
        </template>
      </v-list>
    </v-menu>
  </div>
</template>

<script>

import axios from "axios";

export default {
  name: "MenuActions",
  props: [
    'canDownloadTemplate',
    'canImport',
    'canExport',
    'canDownloadFile',
    'canClearList',
    'export_url',
    'download_url',
  ],

  data () {
    return {
      api_url: "",
    }
  },
  methods: {
    callMethod(method) {
      this.$emit(method)
    },
    showAlert(title, icon) {
      this.$swal({
        position: "center",
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 2500,
      });
    },
  },
  computed: {
    menu() {
      let menu = { 
        hasPermission: false,
        list: [
          { 
            text: "File", 
            icon: "mdi-download", 
            color: "info", 
            method: "download",
            hasPermission: this.canDownloadFile 
          },
          { 
            text: "Import", 
            icon: "mdi-import", 
            color: "primary", 
            method: "import",
            hasPermission: this.canImport 
          },
          { 
            text: "Export", 
            icon: "mdi-microsoft-excel", 
            color: "success", 
            method: "export",
            hasPermission: this.canExport 
          },
          { 
            text: "Clear List", 
            icon: "mdi-delete", 
            color: "error", 
            method: "clearList",
            hasPermission: this.canClearList 
          },
        ]
      };  

      menu.list.forEach(v => {
        if(v.hasPermission)
        {
          menu.hasPermission = true;
        }
      });

      return menu;
    }
  }
}
</script>

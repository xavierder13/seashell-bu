<template>
  <div>
    <v-data-table
      v-model="selectedItems"
      :headers="headers"
      :items="items"
      item-key="id"
      show-select
      :search="search"
      :loading="loading"
      loading-text="Loading... Please wait"
      v-if="canViewList"
    > 
      <template v-slot:top>
        <v-toolbar flat class="my-2">
          <v-toolbar-title class="mt-4">{{ table_title }}  </v-toolbar-title>
          <v-divider vertical class="ma-2" thickness="20px"></v-divider>

          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-btn 
                small 
                class="mx-2 mt-4" 
                color="primary" 
                rounded 
                fab
                v-bind="attrs" v-on="on"
                @click="newData()"
              > 
                <v-icon>mdi-plus</v-icon> 
              </v-btn>
            </template>
            <span>Add Data</span>
          </v-tooltip>
          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-btn 
                small 
                class="mr-2 mt-4 white--text" 
                color="#AB47BC" 
                rounded 
                fab 
                @click="getData()"
                :disabled="loading"
                v-bind="attrs" v-on="on"
              > 
                <v-icon>mdi-refresh</v-icon> 
              </v-btn>
            </template>
            <span>Refresh Data</span>
          </v-tooltip> 
          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-btn 
                small
                class="mr-2 mt-4" 
                color="error" 
                rounded 
                fab 
                :disabled="selectedItems.length ? false : deleteIsDisabled"
                v-if="canDelete"
                @click="deleteSelected()"
                v-bind="attrs" v-on="on"
              > 
                <v-icon>mdi-delete</v-icon> 
              </v-btn>
            </template>
            <span>Delete Selected Row</span>
          </v-tooltip> 
          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-btn 
                small
                class="mr-2 mt-4" 
                color="teal white--text" 
                rounded 
                fab 
                :disabled="!toPublish"
                v-if="canPublish"
                @click="publishAction('publish')"
                v-bind="attrs" v-on="on"
              > 
                <v-icon>mdi-publish</v-icon> 
              </v-btn>
            </template>
            <span>Publish Species</span>
          </v-tooltip> 
          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-btn 
                small
                class="mt-4" 
                color="lime white--text" 
                rounded 
                fab 
                :disabled="!toUnpublish"
                v-if="canPublish"
                @click="publishAction('unpublish')"
                v-bind="attrs" v-on="on"
              > 
                <v-icon>mdi-publish-off</v-icon> 
              </v-btn>
            </template>
            <span>Unpublish Species</span>
          </v-tooltip> 
          
          <!-- <v-btn 
            color="error"  
            :disabled="selectedItems.length ? false : btn_delete_disabled"
            small
            @click="deleteSelected()"
          >
            <v-icon small class="mr-1">mdi-delete</v-icon>Delete Seleted
          </v-btn> -->
          <v-spacer></v-spacer>
          <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details=""
           ></v-text-field>
        </v-toolbar>
      </template>
      <template v-slot:header.data-table-select="{ props, on }">
        <v-simple-checkbox
          v-model="selectAll"
          :value="props.value || props.indeterminate"
          v-on="on"
          :indeterminate="props.indeterminate"
          color="primary"
        />
      </template>

      <template v-slot:item.data-table-select="{ isSelected, select }">
        <v-simple-checkbox color="primary" v-ripple :value="isSelected" @input="select($event)"></v-simple-checkbox>
      </template>

      <template v-slot:item.public="{ item }">
        <v-icon v-if="item.public" color="success">mdi-check-circle</v-icon>
      </template>
      <template v-slot:item.branch="{ item }">
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          small
          class="mr-2"
          color="green"
          @click="editData(item)"
          v-if="canEdit"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          small
          color="red"
          @click="confirmDelete(item)"
          v-if="canDelete"
        >
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
  </div>
</template>
<script>

export default {
  name: "DataTable",
  props :[
    'headers',
    'items',
    'loading',
    'table_title',
    'canViewList',
    'canEdit',
    'canDelete',
    'canPublish',
    'deleteIsDisabled',
    'refreshIsDisabled',
    'publishIsDisabled',
  ],
  data() {
    return {
      selectedItems: [],
      selectAll: false,
      search: "",
    }
  },
  methods: {
    getData() {
      this.$emit("getData");
    },
    newData() {
      this.$emit("new");
    },
    editData(item) {
      this.$emit("edit", item);
    },
    confirmDelete(item) {
      const data = { id: item.id };
      this.$emit("showConfirmDelete", data)
    },
    deleteSelected() {
      const data = { multiple_delete: true, items: this.selectedItems };
      this.$emit("showConfirmDelete", data);
    },
    publishAction(action) {
      this.$emit('publish', this.selectedItems, action);
    },
    resetSelectedItems() {
      this.selectedItems = [];
      this.selectAll = false;
    },
  },
  computed: {
    toPublish() {
      let toPublish = false;
      this.selectedItems.forEach(value => {
        if(value.public == 0)
        {
          toPublish = true;
        }
        
      });

      return toPublish;
    },
    toUnpublish() {
      let toUnpublish = false;
      this.selectedItems.forEach(value => {
        if(value.public == 1)
        {
          toUnpublish = true;
        }
        
      });

      return toUnpublish;
    },
  },
}

</script>

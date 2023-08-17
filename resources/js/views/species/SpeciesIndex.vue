<template>
  <div class="flex column">
    <div id="_wrapper" class="pa-5">
      <v-main>
        <v-breadcrumbs :items="items">
          <template v-slot:item="{ item }">
            <v-breadcrumbs-item :to="item.link" :disabled="item.disabled">
              {{ item.text.toUpperCase() }}
            </v-breadcrumbs-item>
          </template>
        </v-breadcrumbs>
        <MenuActions
          :canImport="hasPermission('species-import')"
          :canExport="hasPermission('species-export')"
          :canClearList="hasPermission('species-clear-list')"
          @import="importExcel"
          @export="exportData"
          @clearList="clearList"
        />
        <v-card>
          <!-- <v-card-title>
            Species List
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
            ></v-text-field>
            <v-spacer></v-spacer>
          </v-card-title> -->
          <DataTable
            table_title="Species List"
            :headers="headers"
            :items="species"
            :search="search"
            :loading="loading"
            :canViewList="hasPermission('species-list')"
            :canEdit="hasPermission('species-edit')"
            :canDelete="hasPermission('species-delete')"
            :canPublish="hasPermission('species-publish')"
            :deleteIsDisabled="deleteIsDisabled"
            :publishIsDisabled="publishIsDisabled"
            @getData="getSpecies"
            @edit="editSpecies"
            @new="openSpeciesDialog"
            @showConfirmDelete="showConfirmDelete"
            @publish="publishAction"
            ref="speciesDataTable"
          />
        </v-card>
      </v-main>
      <ImportDialog 
        :api_route="api_route" 
        :dialog_import="dialog_import"
        :action="action"
        @getData="getSpecies"
        @closeImportDialog="closeImportDialog"
      />

      <v-dialog v-model="dialog_species" persistent>
        <v-card>
          <v-card-title class="pa-4">
            <span class="headline">Species Details</span>
          </v-card-title>
          <v-divider class="mt-0"></v-divider>
          <v-card-text>
            <v-tabs v-model="tab" background-color="blue darken-1" dark class="my-4">
              <v-tab v-for="item in tabs" :key="item.tab">
                {{ item.description }}
              </v-tab>
            </v-tabs>
            <v-tabs-items v-model="tab" class="full-height-tab px-4">
              <v-tab-item class="pt-2">
                <v-row>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="species_name"
                      v-model="speciesItem.name"
                      label="Species Name"
                      :error-messages="speciesNameErrors + speciesError.name"
                      @input="$v.speciesItem.name.$touch() + (speciesError.name = [])"
                      @blur="$v.speciesItem.name.$touch()"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="kingdom"
                      v-model="speciesItem.kingdom"
                      label="Kingdom"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="phylum"
                      v-model="speciesItem.phylum"
                      label="Phylum"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="shell_class"
                      v-model="speciesItem.shell_class"
                      label="Class"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="order"
                      v-model="speciesItem.order"
                      label="Order"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="family"
                      v-model="speciesItem.family"
                      label="Family"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="genus"
                      v-model="speciesItem.genus"
                      label="Genus"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="species"
                      v-model="speciesItem.species"
                      label="Species"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="common_name"
                      v-model="speciesItem.common_name"
                      label="Common Name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="local_name"
                      v-model="speciesItem.local_name"
                      label="Local Name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="country"
                      v-model="speciesItem.country"
                      label="Country"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="environment"
                      v-model="speciesItem.environment"
                      label="Environment"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <!-- <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="general_description"
                      v-model="speciesItem.general_description"
                      label="General Description"
                    ></v-text-field>
                    <v-textarea
                      name="general_description"
                      v-model="speciesItem.general_description"
                      label="General Description"
                    ></v-textarea>
                  </v-col> -->
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="iucn_status"
                      v-model="speciesItem.iucn_status"
                      label="IUCN Status"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="threats_to_humans"
                      v-model="speciesItem.threats_to_humans"
                      label="Threats to Humans"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="economic_value_uses"
                      v-model="speciesItem.economic_value_uses"
                      label="Economic Value/ Uses"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="remarks"
                      v-model="speciesItem.remarks"
                      label="Remarks"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <!-- <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="references"
                      v-model="speciesItem.references"
                      label="References"
                    ></v-text-field>
                  </v-col> -->
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="class_sequence"
                      v-model="speciesItem.species_id"
                      label="Class Sequence"
                      :error-messages="classSequenceErrors + speciesError.species_id"
                      @input="$v.speciesItem.species_id.$touch() + (speciesError.species_id = [])"
                      @blur="$v.speciesItem.species_id.$touch()"
                      @keypress="numValFilter()"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="code"
                      v-model="speciesItem.code"
                      label="Code"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <v-text-field
                      name="unique_duplicate"
                      v-model="speciesItem.unique_duplicate"
                      label="Unique/Duplicate"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="3" lg="3" xl="3" class="my-0 py-0">
                    <div class="d-flex">
                      <v-switch
                        v-model="switchPublic"
                        :label="`Public: ${switchPublic.toString()}`"
                        inset
                      >
                        <template v-slot:label>
                          <v-chip class="ml-1" :color="switchPublic ? 'primary' : ''">  {{ switchPublic ? 'Public' : 'Private'}} </v-chip>
                        </template>
                      </v-switch>
                    </div>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" xs="12" sm="6" md="6" lg="6" xl="6" class="my-0 py-0">
                    <v-textarea
                      name="general_description"
                      v-model="speciesItem.general_description"
                      label="General Description"
                    ></v-textarea>
                  </v-col>
                  <v-col cols="12" xs="12" sm="6" md="6" lg="6" xl="6" class="my-0 py-0">
                    <v-textarea
                      name="references"
                      v-model="speciesItem.references"
                      label="References"
                    ></v-textarea>
                  </v-col>
                </v-row>
              </v-tab-item>
              <v-tab-item class="pt-2">
                <v-row>
                  <v-col class="my-0 py-0">
                    <v-file-input
                      v-model="speciesItem.file"
                      show-size
                      label="File input"
                      prepend-icon="mdi-paperclip"
                      required
                      multiple
                      :error-messages="fileErrors"
                    >
                      <template v-slot:selection="{ index, text }">
                        <v-chip small label color="primary" close @click:close="removeFile(index, text)">
                          {{ text }}
                        </v-chip>
                      </template>
                    </v-file-input>
                  </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                  <v-col
                    v-for="(image, i) in speciesItem.species_files"
                    :key="i"
                    class="d-flex child-flex"
                    cols="12"
                    sm="2"
                    md="2"
                    lg="2"
                    xl="2"
                  >
                    <v-card>               
                      <v-fab-transition>   
                        <v-btn
                          color="error"
                          fab
                          dark
                          x-small
                          absolute  
                          right
                          class="mt-4 ml-8"
                          @click="confirmRemoveImage(image)"
                        >
                          <v-icon small>mdi-delete</v-icon>
                        </v-btn>
                      </v-fab-transition>
                      <v-img
                        :src="image.file_path + '/' + image.file_name"
                        aspect-ratio="1"
                        cover
                        class="bg-grey-lighten-2"
                      >  
                        <!-- <v-card-title class="align-end fill-height" primary-title>
                          <v-btn class="blue" style="z-index: 9999" v-on:click.stop="action2">clickable</v-btn>
                        </v-card-title> -->
                        <template v-slot:placeholder>
                          <v-row
                            class="fill-height ma-0"
                            align="center"
                            justify="center"
                          >
                            <v-progress-circular
                              indeterminate
                              color="grey-lighten-5"
                            ></v-progress-circular>
                          </v-row>
                        </template>
                      </v-img>                 
                    </v-card>
                  </v-col>
                </v-row>
              </v-tab-item>
            </v-tabs-items>
            
          </v-card-text>
          <v-divider class="mb-3 mt-0"></v-divider>
          <v-card-actions class="pr-4">
            <v-spacer></v-spacer>
            <v-btn
              color="#E0E0E0"
              @click="closeSpeciesDialog()"
              class="mb-3"
            >
              Cancel
            </v-btn>
            <v-btn
              color="primary"
              class="mb-3 mr-4"
              @click="saveData()"
              :disabled="saveDisabled"
            >
              {{ btnSaveLabel }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="dialog_delete_loading" max-width="500px" persistent>
        <v-card>
          <v-card-text>
            <v-container>
              <v-row
                class="fill-height"
                align-content="center"
                justify="center"
              >
                <v-col class="subtitle-1 font-weight-bold text-center mt-4" cols="12">
                  Deleting Data...
                </v-col>
                <v-col cols="6">
                  <v-progress-linear
                    color="primary"
                    indeterminate
                    rounded
                    height="6"
                  ></v-progress-linear>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
  </div>
</template>
<style scoped>
.v-tabs-items.full-height-tab  .v-window-item {
  height: calc(85vh - 200px); /* Adjust 270px to suits your needs */
  overflow-y: auto;
  overflow-x: hidden;
}
</style>
<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import { mapState, mapGetters, mapActions } from "vuex";
import ImportDialog from '../../components/ImportDialog.vue';
import MenuActions from "../../components/MenuActions.vue";
import DataTable from "../../components/DataTable.vue";

export default {
  name: "SpeciesIndex",
  components: {
    ImportDialog,
    MenuActions,
    DataTable,
  },
  mixins: [validationMixin],

  validations: {
    speciesItem: {
      species_id: { required },
      name: { required },
    }
    
  },
  data() {
    return {
      search: "",
      headers: [
        { text: "ID", value: "id" },
        { text: "Name", value: "name" },
        { text: "Kingdom", value: "kingdom" },
        { text: "Phylum", value: "phylum" },
        { text: "Class", value: "class" },
        { text: "Order", value: "family" },
        { text: "Genus", value: "genus" },
        { text: "Species", value: "species" },
        { text: "Publish", value: "public" },
        { text: "Actions", value: "actions", sortable: false, width: "80px" },
      ],
      disabled: false,
      dialog: false,
      dialog_unreconciled: false,
      dialog_recon_loading: false,
      species: [],
      selectedSpecies: [],
      editedIndex: -1,
      speciesItem: {
        name: "",
        kingdom: "",
        phylum: "",
        shell_class: "",
        order: "",
        family: "",
        genus: "",
        species: "",
        common_name: "",
        local_name: "",
        country: "",        
        environment: "",        
        general_description: "",       
        iucn_status: "",       
        threats_to_humans: "",       
        economic_value_uses: "",       
        references: "",      
        class_sequence: "",    
        species_id: "",        
        unique_duplicate: "",
        remarks: "",
        public: "",
        file: [],
      },
      defaultSpeciesItem: {
        name: "",
        kingdom: "",
        phylum: "",
        shell_class: "",
        order: "",
        family: "",
        genus: "",
        species: "",
        common_name: "",
        local_name: "",
        country: "",        
        environment: "",        
        general_description: "",       
        iucn_status: "",       
        threats_to_humans: "",       
        economic_value_uses: "",       
        references: "",      
        class_sequence: "",    
        species_id: "",        
        unique_duplicate: "",
        remarks: "",
        public: false,
        file: [],
      },
      items: [
        {
          text: "Home",
          disabled: false,
          link: "/",
        },
        {
          text: "Species Lists",
          disabled: false,
          link: "/species/index"
        },
        {
          text: "View",
          disabled: true,
        },
      ],
      loading: true,
      loading_unreconciled: true,
      json_fields: {
        BRAND: "brand.name",
        MODEL: "model",
        SERIAL: "serial",
        QUANTITY: " ",
      },
      action: "",
      api_route: "",
      dialog_import: false,
      swalAttr: {
        title: "Delete Record",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonColor: "#d33", 
        confirmButtonText: "Delete Record"
      },
      deleteIsDisabled: true,
      publishIsDisabled: true,
      saveDisabled: false,
      dialog_species: false,
      dialog_delete_loading: false,
      switchPublic: false,
      tab: null,
      tabs: [
        { tab: 1, description: "Species Details"},
        { tab: 2, description: "Images"},
      ],
      fileIsInvalid: false,
      removedFiles: [],
      speciesError: {
        name: [],
        species_id: [],
      }

    };
  },

  watch: {
    userIsLoaded: {
      handler() {
        if (this.userIsLoaded && this.userRolesPermissionsIsLoaded) {
          this.getSpecies();
        }
      },
    },
    userRolesPermissionsIsLoaded: {
      handler() {
        if (this.userIsLoaded && this.userRolesPermissionsIsLoaded) {
          this.getSpecies();
        }
      },
    },
    switchPublic() {
      this.speciesItem.public = this.switchPublic;
    }
  },

  methods: {
    getSpecies() {
      this.loading = true;

      axios.get("/api/species2/index").then(
        (response) => {
          this.species = response.data.species;
          this.loading = false;
        },
        (error) => {
          this.isUnauthorized(error);
        }
      );
    },

    saveData() {
      this.$v.$touch();

      if (!this.$v.$error && !this.fileIsInvalid) {

        let formData = new FormData();
        const data = this.speciesItem;
        let fieldName = Object.keys(data);
        let fieldValue;
        fieldName.forEach(field => {
          let value = this.speciesItem[`${field}`];
          fieldValue = value ? value : '';

          if (field != 'file') {
            formData.append(field, fieldValue);
          }
          else
          {
            // create array formData for file
            fieldValue.forEach(val => {
              formData.append('file[]', val);
            });
            
          }
          
        });

        this.removedFiles.forEach((val, i) => {
           formData.append('removed_files['+i+']', val.id);
        });
       
        if (!this.$v.$error) {
          this.disabled = true;
      
          const species_id = this.speciesItem.id;
          let url = "/api/species2" + (this.editedIndex > -1 ? "/update/" + species_id : "/store");

          axios.post(url, formData, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("access_token"),
                "Content-Type": "multipart/form-data",
              }
          }).then(
            (response) => {
              let data = response.data;
              console.log(data);
              if (data.success) {
                // send data to Sockot.IO Server
                // this.$socket.emit("sendData", { action: "species-edit" });

                if(this.editedIndex > -1)
                {
                  Object.assign(this.species[this.editedIndex], data.species);
                  this.speciesItem.file = [];
                  this.speciesItem.species_files = data.species.species_files;
                }
                else
                {
                  this.species.push(data.species);
                }
                
                this.showAlert(data.success, 'success');
                if(this.editedIndex === -1)
                {
                  this.closeSpeciesDialog();
                }
                
              } else if (data.error) {
                let errors = data.error;
                let errorNames = Object.keys(errors);

                errorNames.forEach(value => {
                  this.speciesError[value].push(errors[value]);
                });
              }

              this.disabled = false;
            },
            (error) => {
              this.isUnauthorized(error);
              this.disabled = false;
            }
          );
        }
      }
      
    },

    editSpecies(item) {
      this.switchPublic = item.public ? true : false;
      this.editedIndex = this.species.indexOf(item);
      this.speciesItem = Object.assign({}, item);
      this.dialog_species = true;
      console.log(item);
    },

    importExcel() {
      this.dialog_import = true;
    },

    exportData() {

      if (this.species.length) {

        axios.get('/api/species2/export_species', { responseType: 'arraybuffer'})
          .then((response) => {
              var fileURL = window.URL.createObjectURL(new Blob([response.data]));
              var fileLink = document.createElement('a');
              fileLink.href = fileURL;
              fileLink.setAttribute('download', 'Shellsinformation.xls');
              document.body.appendChild(fileLink);
              fileLink.click();
          }, (error) => {
            console.log(error);
          }
        );
      }
      else {
        this.showAlert('No record found', 'warning');
      }

    },

    openSpeciesDialog() {
      this.dialog_species = true;
    },

    closeSpeciesDialog() {
      this.dialog_species = false;
      this.resetData();
    },

    resetData() {
      this.$v.$reset();
      this.speciesItem = Object.assign({}, this.defaultSpeciesItem);
      this.tab = null;
      this.removedFiles = [];
    },

    removeFile(index) {
      this.speciesItem.file.splice(index, 1);
    },

    showAlert(msg, icon) {
      this.$swal({
        position: "center",
        icon: icon,
        title: msg,
        showConfirmButton: false,
        timer: 2500,
      });
    },

    showConfirmDelete(data) {
      // if delete action is multiple delete
      
      if(data.multiple_delete)
      {
        Object.assign(this.swalAttr, { title: "Delete Multiple Record", confirmButtonText: "Delete Record" });
      }
      
      this.$swal(this.swalAttr).then((result) => {
        if (result.value) {
          
          this.$refs.speciesDataTable.resetSelectedItems();
      
          this.deleteIsDisabled = true;
          this.dialog_delete_loading = true;
          this.loading = true;
          axios.post("/api/species2/delete", data).then(
            (response) => {
              console.log(response.data);
              this.dialog_delete_loading = false;
              if (response.data.success) {
                this.showAlert(response.data.success, 'success');
                this.getSpecies();
              }
              this.loading = false;
            },
            (error) => {
              this.isUnauthorized(error);
            }
          );
        }
      });
    },
    confirmRemoveImage(item) {
     
      Object.assign(this.swalAttr, { title: "Remove Image", confirmButtonText: "Remove" });
      this.$swal(this.swalAttr).then((result) => {
        if (result.value) {
          let images = this.speciesItem.species_files;
          let i = images.indexOf(item);

          this.removedFiles.push(item);

          images.splice(i, 1);
        }
      });
      
    },
    publishAction(items, action) {

      let actionLabel = action.charAt(0).toUpperCase() + action.slice(1)

      this.$swal({
        title: actionLabel + " Species",
        text: "You are about to " + action + " species details!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonColor: "#1976d2", 
        confirmButtonText: actionLabel
      }).then((result) => {
        if (result.value) {

          this.publishIsDisabled = true;

          const data = { items: items, action: action };

          axios.post("/api/species2/publish", data).then(
            (response) => {
              console.log(response.data);

              if (response.data.success) {
                this.showAlert(response.data.success, 'success');
                this.$refs.speciesDataTable.resetSelectedItems();
                this.getSpecies();
              }
              this.loading = false;
            },
            (error) => {
              this.isUnauthorized(error);
            }
          );  
        }
      });
    },
    clearList()
    {
      const data = { multiple_delete: true, items: this.species };
      this.showConfirmDelete(data);
    },
    close() {
      this.dialog = false;
      this.clear();
      this.$nextTick(() => {
        this.speciesItem = Object.assign({}, this.defaultSpeciesItem);
        this.editedIndex = -1;
      });
    },
    closeImportDialog() { 
      this.dialog_import = false;
    },
    clear() {
      this.$v.$reset();
      this.speciesItem = Object.assign({}, this.defaultSpeciesItem);
    },

    isUnauthorized(error) {
      // if unauthenticated (401)
      if (error.response.status == "401") {
        this.$router.push({ name: "unauthorize" });
      }
    },

    numValFilter(evt) {
      evt = (evt) ? evt : window.event;
      let expect = evt.target.value.toString() + evt.key.toString();
      
      if (!/^[-+]?[0-9]*?[0-9]*$/.test(expect)) {
        evt.preventDefault();
      } else {
        return true;
      }
    }
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New" : "Edit" + "Species";
    },

    tableHeaders() {
      let headers = [];

      this.headers.forEach((value) => {
        headers.push(value);
      });

      // remove Actions column if user is not permitted
      if (!this.hasPermission('species-edit', 'species-delete')) {
        headers.splice(5, 1);
      }

      return headers;
    },
    btnSaveLabel() {
      return this.editedIndex === -1 ? "Add" : 'Update';
    },
    speciesNameErrors() {
      const errors = [];

      if (!this.$v.speciesItem.name.$dirty) return errors;
      !this.$v.speciesItem.name.required &&
        errors.push("Species Name is required.");
      return errors;
    },
    classSequenceErrors() {
      const errors = [];
      if (!this.$v.speciesItem.species_id.$dirty) return errors;
      !this.$v.speciesItem.species_id.required &&
        errors.push("Class Sequence is required.");
      return errors;
    },
    fileErrors() {
      const errors = [];
      let files = this.speciesItem.file;
      this.fileIsInvalid = false
      ;
      if(files != null)
      {
        files.forEach(file => {
          if(file.name)
          {
            let split_arr = file.name.split('.');
            let split_ctr = split_arr.length;
            let extension = split_arr[split_ctr - 1];
            let extensions = ['jpg', 'jpeg', 'png'];

            if(!extensions.includes(extension))
            {
              this.fileIsInvalid = true;
            }
          }
        });  
      }

      this.fileIsInvalid && errors.push("File type must be 'jpg', 'jpeg', 'png'.");
      return errors;
    },
    ...mapState("auth", ["user", "userIsLoaded"]),
    ...mapState("userRolesPermissions", ["userRolesPermissionsIsLoaded"]),
    ...mapGetters("userRolesPermissions", ["hasRole", "hasPermission", "hasAnyPermission"]),
  },

  async mounted() {
    axios.defaults.headers.common["Authorization"] =
      "Bearer " + localStorage.getItem("access_token");
    
    this.api_route = 'api/species2/import_species'; //set api route for uploading excel

    if (this.userIsLoaded && this.userRolesPermissionsIsLoaded) {

      this.getSpecies();
      
    }

  },
};
</script>
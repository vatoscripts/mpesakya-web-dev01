<template>
  <div class="content-wrapper">
    <h4 class="content-heading">
      <div>
        M-pesa KYA Portal
        <p class="lead mt-2">Onboard Aggregator: Details</p>
      </div>
    </h4>
    <div class="col-8 vld-parent" ref="formContainer">
      <div class="clearfix"></div>
      <div
        v-show="message"
        class="alert alert-warning alert-block mt-1 text-center"
      >
        <span class="h3">{{ message }}</span>
      </div>
      <form @submit.prevent="submit" class="mb-3">
        <div class="form-group">
          <label class="text-bold">Mobile Number</label>
          <input
            id="mobile-phone"
            name="mobilePhone"
            class="form-control"
            type="text"
            placeholder="Enter Mobile Number strating with 255..."
            v-model="fields.mobilePhone"
          />
          <div v-if="errors && errors.mobilePhone" class="text-danger">
            {{ errors.mobilePhone[0] }}
          </div>
        </div>

        <div class="form-group">
          <label class="text-bold">Business Name</label>
          <input
            name="businessName"
            type="text"
            class="form-control"
            id="validationTooltip01"
            placeholder="Company/Business Name"
            v-model="fields.businessName"
          />
          <div v-if="errors && errors.businessName" class="text-danger">
            {{ errors.businessName[0] }}
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-5 col-xs-12 mb-3">
            <label class="text-bold">Business TIN Number</label>
            <input
              name="TIN"
              type="text"
              class="form-control"
              id="validationTooltip01"
              placeholder="TIN"
              v-model="fields.TIN"
            />
            <div v-if="errors && errors.TIN" class="text-danger">
              {{ errors.TIN[0] }}
            </div>
          </div>
          <div class="col-md-7 col-xs-12 mb-3">
            <div class="custom-file">
              <label class="text-bold"
                >Upload a Valid TIN file in JPG or PNG</label
              >
              <input
                type="file"
                class="form-control-file"
                ref="TINFile"
                id="TINFile"
                v-on:change="handleTINFileUpload()"
              />
              <div v-if="errors && errors.TINFile" class="text-danger">
                {{ errors.TINFile[0] }}
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-5 col-xs-12 mb-3">
            <label class="text-bold">Business Licence Number</label>
            <input
              name="businessLicence"
              type="text"
              class="form-control"
              id="validationTooltip01"
              placeholder="Business Licence No"
              v-model="fields.businessLicence"
            />
            <div v-if="errors && errors.businessLicence" class="text-danger">
              {{ errors.businessLicence[0] }}
            </div>
          </div>
          <div class="col-md-7 col-xs-12 mb-3">
            <div class="custom-file">
              <label class="text-bold">
                Upload a Valid Business Licence file in JPG or PNG format
              </label>
              <input
                type="file"
                class="form-control-file"
                ref="businessLicenceFile"
                id="businessLicenceFile"
                v-on:change="handleLicenceFileUpload()"
              />
              <div
                v-if="errors && errors.businessLicenceFile"
                class="text-danger"
              >
                {{ errors.businessLicenceFile[0] }}
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="text-bold">Business ShortCode</label>
          <input
            name="shortCode"
            type="text"
            class="form-control"
            id="validationTooltip01"
            placeholder="Company/Business Short Code"
            v-model="fields.shortCode"
          />
          <div v-if="errors && errors.shortCode" class="text-danger">
            {{ errors.shortCode[0] }}
          </div>
        </div>

        <div class="form-group">
          <label class="text-bold">Business Category</label>

          <select
            class="form-control"
            name="aggregatorCategory"
            id="aggregator-category-dropdown"
            v-model="fields.aggregatorCategory"
          >
            <option value selected disabled>Choose Category</option>
            <option
              v-for="Category in categories"
              v-bind:value="Category.ID"
              v-bind:key="Category.ID"
            >
              {{ Category.Description }}
            </option>
          </select>
          <div v-if="errors && errors.aggregatorCategory" class="text-danger">
            {{ errors.aggregatorCategory[0] }}
          </div>
        </div>

        <div class="form-row mb-2">
          <div class="col-4">
            <label class="text-bold">Business Zone</label>

            <select
              class="form-control"
              name="aggregatorZone"
              id="agent-category-dropdown"
              @change="onZoneChange"
            >
              <option value selected disabled>Choose Zone</option>
              <option
                v-for="zone in zones"
                v-bind:value="zone.ID"
                v-bind:key="zone.ID"
              >
                {{ zone.Description }}
              </option>
            </select>
          </div>

          <div class="col-4">
            <label class="text-bold">Business Region</label>

            <select
              class="form-control"
              name="aggregatorRegion"
              id="aggregator-region-dropdown"
              @change="onRegionChange"
            >
              <option value selected disabled>Choose Region</option>
              <option
                v-for="region in regions"
                v-bind:value="region.ID"
                v-bind:key="region.ID"
              >
                {{ region.Description }}
              </option>
            </select>
          </div>
          <div class="col-4">
            <label class="text-bold">Business Territory</label>

            <select
              class="form-control"
              name="aggregatorTerritory"
              id="aggregator-territory-dropdown"
              v-model="fields.aggregatorTerritory"
            >
              <option value selected disabled>Choose Territory</option>
              <option
                v-for="territory in territories"
                v-bind:value="territory.ID"
                v-bind:key="territory.ID"
              >
                {{ territory.Description }}
              </option>
            </select>
            <div
              v-if="errors && errors.aggregatorTerritory"
              class="text-danger"
            >
              {{ errors.aggregatorTerritory[0] }}
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="text-bold">Email address</label>
          <input
            name="aggregatorEmail"
            type="email"
            class="form-control"
            placeholder="Enter email"
            v-model="fields.aggregatorEmail"
          />
          <div v-if="errors && errors.aggregatorEmail" class="text-danger">
            {{ errors.aggregatorEmail[0] }}
          </div>
        </div>
        <div class="form-group">
          <label class="text-bold">Telephone Number</label>
          <input
            name="aggregatorPhone"
            type="text"
            class="form-control"
            aria-describedby="emailHelp"
            placeholder="Phone Number"
            v-model="fields.aggregatorPhone"
          />
          <div v-if="errors && errors.aggregatorPhone" class="text-danger">
            {{ errors.aggregatorPhone[0] }}
          </div>
        </div>

        <!--Material textarea-->
        <div class="form-group">
          <label class="text-bold" for="form7">Address Location</label>
          <textarea
            name="aggregatorAdress"
            id="form7"
            class="md-textarea form-control"
            rows="3"
            v-model="fields.aggregatorAdress"
          ></textarea>
          <div v-if="errors && errors.aggregatorAdress" class="text-danger">
            {{ errors.aggregatorAdress[0] }}
          </div>
        </div>

        <button
          id="sendAggregatorNIDA"
          type="submit"
          class="btn btn-lg btn-primary"
        >
          <em class="mr-2 fas fa-check"></em> Onboard Aggregator
        </button>
      </form>
    </div>
  </div>
</template>

<script>

export default {

  data() {
    return {
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      loading: true,
      message: null,
      TINFile: "",
      zones: null,
      zoneID: null,
      regions: null,
      region: null,
      territories: null,
      categories: [
        { ID: 1, Description: "Aggregator" },
        { ID: 4, Description: "TDR" },
      ],
    };
  },
  mounted() {
    setTimeout(() => {
      axios
        .get("/api/zone")
        .then((response) => {
          this.zones = response.data;
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: "An error occured while fetching zones : " + error,
          });
        });
    }, 2000);
  },
  methods: {
    submit() {
      this.errors = {};
      this.message = null;

      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        "is-full-page": false,
        loader: "dots",
        color: "red",
      });

      let formData = new FormData();

      for (var key in this.fields) {
        formData.append(key, this.fields[key]);
      }

      axios
        .post("/api/aggregator/onboard/second", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          console.log(response.data);
          loader.hide();

           Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: 'Aggregator onboarded Succesful !'
                    }).then(() => {
                        this.$router.push({ name: "home" });
                    });

        })
        .catch((error) => {
          this.loaded = true;
          loader.hide();
          console.log(error);
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          } else {
            this.message = error.response.data.message;
          }
        });
    },
    handleTINFileUpload() {
      //console.log(this.$refs.TINFile.files[0]);
      this.fields.TINFile = this.$refs.TINFile.files[0];
    },

    handleLicenceFileUpload() {
      this.fields.businessLicenceFile = this.$refs.businessLicenceFile.files[0];
    },

    onZoneChange(e) {
      axios
        .get("/api/region/" + e.target.value)
        .then((response) => {
          // console.log(response.data);
          this.regions = response.data;
          this.territories = null;
          this.region = "";
          this.fields.aggregatorTerritory = "";
        })
        .catch((error) => {
          console.log(error);
        });
    },

    onRegionChange(e) {
      axios
        .get("/api/territory/" + e.target.value)
        .then((response) => {
          this.fields.aggregatorTerritory = "";
          this.territories = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

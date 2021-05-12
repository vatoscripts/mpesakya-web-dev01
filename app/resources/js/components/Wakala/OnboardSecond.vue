<template>
    <div class="content-wrapper">
        <h4 class="content-heading">
            <div>
                M-pesa KYA Portal
                <p class="lead mt-2">Onboard Wakala: Details</p>
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
            <form @submit.prevent="submit" class="mb-3" id="loginForm">
                <div class="form-row">
                    <div class="form-group col-6">
                        <label class="text-bold">Business Name</label>
                        <input
                            name="businessName"
                            type="text"
                            class="form-control"
                            id="validationTooltip01"
                            placeholder="Company or Business Name"
                            v-model="fields.businessName"
                        />

                        <div
                            v-if="errors && errors.businessName"
                            class="text-danger"
                        >
                            {{ errors.businessName[0] }}
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="text-bold">Business Group</label>
                        <select
                            class="custom-select text-center"
                            name="businessGroup"
                            id="wakala-group-dropdown"
                            @change="onBusinessGroupChange($event)"
                        >
                            <option value selected disabled
                                >Choose Group</option
                            >
                            <option
                                v-for="group in groups"
                                v-bind:value="group.ID"
                                v-bind:key="group.ID"
                            >
                                {{ group.Description }}
                            </option>
                        </select>
                        <div
                            v-if="errors && errors.businessGroup"
                            class="text-danger"
                        >
                            {{ errors.businessGroup[0] }}
                        </div>
                    </div>
                </div>

                <div class="form-row mb-4" v-show="showBrela">
                    <div class="col-md-6 col-xs-12 mb-3">
                        <div class="custom-file">
                            <label class="text-bold">
                                Upload a valid Incorporation file in JPG or PNG
                                format
                            </label>
                            <input
                                type="file"
                                class="form-control-file"
                                ref="brelaFile"
                                id="brelaFile"
                                v-on:change="handleBrelaFileUpload()"
                            />
                            <div
                                v-if="errors && errors.brelaFile"
                                class="text-danger"
                            >
                                {{ errors.brelaFile[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 mb-3" v-show="showMemart">
                        <div class="custom-file">
                            <label class="text-bold">
                                Upload a valid MEMART file in JPG or PNG format
                            </label>
                            <input
                                type="file"
                                class="form-control-file"
                                ref="memartFile"
                                id="memartFile"
                                v-on:change="handleMemartFileUpload()"
                            />
                            <div
                                v-if="errors && errors.memartFile"
                                class="text-danger"
                            >
                                {{ errors.memartFile[0] }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label class="text-bold">Business Mobile Number</label>
                        <input
                            name="businessPhone"
                            type="text"
                            class="form-control"
                            id="validationTooltip01"
                            placeholder="Company or Business mobile number e.g 255..."
                            v-model="fields.businessPhone"
                        />
                        <div
                            v-if="errors && errors.businessPhone"
                            class="text-danger"
                        >
                            {{ errors.businessPhone[0] }}
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label class="text-bold">MPESA Mobile Number</label>
                        <input
                            id="mobile-phone"
                            name="mpesaMobilePhone"
                            class="form-control"
                            type="text"
                            placeholder="Enter Mobile Number strating with 255..."
                            v-model="fields.mpesaMobilePhone"
                        />
                        <div
                            v-if="errors && errors.mpesaMobilePhone"
                            class="text-danger"
                        >
                            {{ errors.mpesaMobilePhone[0] }}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label class="text-bold">Business Till Number</label>
                        <input
                            name="tillNumber"
                            type="text"
                            class="form-control"
                            placeholder="Enter business till number"
                            v-model="fields.tillNumber"
                        />
                        <div
                            v-if="errors && errors.tillNumber"
                            class="text-danger"
                        >
                            {{ errors.tillNumber[0] }}
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label class="text-bold">MPESA Short Code</label>
                        <input
                            name="shortCode"
                            class="form-control"
                            type="text"
                            placeholder="Enter M-Pesa short code "
                            v-model="fields.shortCode"
                        />
                        <div
                            v-if="errors && errors.shortCode"
                            class="text-danger"
                        >
                            {{ errors.shortCode[0] }}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-5 mb-3">
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
                    <div class="col-7 mb-3">
                        <div class="custom-file">
                            <label class="text-bold"
                                >Upload a valid TIN file in JPG or PNG</label
                            >
                            <input
                                type="file"
                                class="form-control-file"
                                ref="TINFile"
                                id="TINFile"
                                v-on:change="handleTINFileUpload()"
                            />
                            <div
                                v-if="errors && errors.TINFile"
                                class="text-danger"
                            >
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
                        <div
                            v-if="errors && errors.businessLicence"
                            class="text-danger"
                        >
                            {{ errors.businessLicence[0] }}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12 mb-3">
                        <div class="custom-file">
                            <label class="text-bold">
                                Upload a valid Business Licence file in JPG or
                                PNG format
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
                            <option value selected disabled
                                >Choose Region</option
                            >
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
                            v-model="fields.wakalaTerritory"
                        >
                            <option value selected disabled
                                >Choose Territory</option
                            >
                            <option
                                v-for="territory in territories"
                                v-bind:value="territory.ID"
                                v-bind:key="territory.ID"
                            >
                                {{ territory.Description }}
                            </option>
                        </select>
                        <div
                            v-if="errors && errors.wakalaTerritory"
                            class="text-danger"
                        >
                            {{ errors.wakalaTerritory[0] }}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-bold">Contact Full Name</label>
                    <input
                        name="contactName"
                        type="text"
                        class="form-control"
                        placeholder="Enter full name"
                        v-model="fields.contactName"
                    />
                    <div
                        v-if="errors && errors.contactName"
                        class="text-danger"
                    >
                        {{ errors.contactName[0] }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-bold">Contact Phone Number</label>
                    <input
                        name="contactPhone"
                        type="text"
                        class="form-control"
                        placeholder="Phone Number e.g 255..."
                        v-model="fields.contactPhone"
                    />
                    <div
                        v-if="errors && errors.contactPhone"
                        class="text-danger"
                    >
                        {{ errors.contactPhone[0] }}
                    </div>
                </div>

                <button
                    id="sendAggregatorNIDA"
                    type="submit"
                    class="btn btn-lg btn-primary"
                >
                    <em class="mr-2 fas fa-check"></em> Onboard Wakala
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
            groups: null,
            showBrela: false,
            showMemart: false
        };
    },
    mounted() {
        (this.groups = [
            { ID: 1, Description: "Company" },
            { ID: 2, Description: "Others" },
            { ID: 3, Description: "Individual" },
            { ID: 4, Description: "Individual With Businessname" }
        ]),
            axios
                .get("/api/zone")
                .then(response => {
                    //console.log(response.data);
                    this.zones = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
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
                color: "red"
            });

            let formData = new FormData();
            //formData.append("TINFile", this.TINFile);

            for (var key in this.fields) {
                formData.append(key, this.fields[key]);
            }

            axios
                .post("/api/wakala/onboard/second", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    loader.hide();

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.data.message
                    }).then(() => {
                        window.location = "/home";
                    });
                })
                .catch(error => {
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

        handleBrelaFileUpload() {
            //console.log(this.$refs.TINFile.files[0]);
            this.fields.brelaFile = this.$refs.brelaFile.files[0];
        },

        handleMemartFileUpload() {
            this.fields.memartFile = this.$refs.memartFile.files[0];
        },

        onZoneChange(e) {
            axios
                .get("/api/region/" + e.target.value)
                .then(response => {
                    // console.log(response.data);
                    this.regions = response.data;
                    this.territories = null;
                    this.region = "";
                    this.fields.wakalaTerritory = "";
                })
                .catch(error => {
                    console.log(error);
                });
        },

        onRegionChange(e) {
            axios
                .get("/api/territory/" + e.target.value)
                .then(response => {
                    this.fields.wakalaTerritory = "";
                    this.territories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        onBusinessGroupChange(e) {
            this.fields.businessGroup = e.target.value;
            if (e.target.value == 1) {
                this.showBrela = true;
                this.showMemart = true;
            } else if (e.target.value == 4) {
                this.showBrela = true;
                this.showMemart = false;
            } else {
                this.showBrela = false;
                this.showMemart = false;
            }
        }
    }
};
</script>

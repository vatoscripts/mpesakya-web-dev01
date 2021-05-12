<template>
  <div class="vld-parent" ref="formContainer">
    <h3>Wakala recruiter list</h3>

    <button class="btn btn-lg btn-success mb-3" data-toggle="modal" data-target="#addNewRecruiter">
      Add Wakala recruiter
      <i class="fas fa-user-plus fa-fw"></i>
    </button>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="table-ext-3">
        <thead>
          <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Created Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="wakala in wakalas" v-bind:key="wakala.MpesaAgentID">
            <td>{{wakala.OrganizationName}}</td>
            <td>{{wakala.Category}}</td>
            <td>{{wakala.CreatedDate}}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->

    <div
      class="modal fade"
      id="addNewRecruiter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewRecruiterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLongTitle">Create new Recruiter</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="addNewRecruiter" class="mb-3" id="loginForm" novalidate>
            <div class="modal-body">
              <div class="form-group">
                <div class="input-group with-focus">
                  <input
                    name="recruiterPhone"
                    class="form-control border-right-0"
                    type="text"
                    placeholder="Enter Phone Number"
                    v-model="fields.recruiterPhone"
                  />
                  <div class="input-group-append">
                    <span class="input-group-text text-muted bg-transparent border-left-0">
                      <em class="fa fa-phone"></em>
                    </span>
                  </div>
                </div>

                <div
                  v-if="errors && errors.recruiterPhone"
                  class="text-danger"
                >{{ errors.recruiterPhone[0] }}</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Onboard</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      wakala: "",
      wakalas: null,
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      loading: true,
      message: null
    };
  },
  mounted() {
    this.getlist();
    loading: false;
  },
  methods: {
    addNewRecruiter() {
      if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        this.message = null;
        axios
          .post("/api/wakala/onboard/recruiter", this.fields)
          .then(response => {
            console.log(response.data);
            this.fields = {}; //Clear input fields.
            this.loaded = true;
            this.success = true;

            Toast.fire({
              icon: "success",
              title: data.message
            });

            $("#addNewRecruiter").modal("hide");
            $(".modal-backdrop").remove();
          })
          .catch(error => {
            this.loaded = true;

            console.log(error);
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            } else {
              this.message = error.response.data.message;
            }
          });
      }
    },

    getlist() {
      //console.log(this.$refs.formContainer);
      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        "is-full-page": true,
        loader: "dots",
        color: "red"
      });

      axios
        .get("/api/wakala/all")
        .then(response => {
          //console.log(response.data);
          this.wakalas = response.data;
          loader.hide();
        })
        .catch(error => {
          loader.hide();
          console.log(error);
        });
    }
  }
};
</script>

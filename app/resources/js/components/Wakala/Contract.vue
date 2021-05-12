<template>
  <div class="content-wrapper">
    <h4 class="content-heading">
      <div>
        M-pesa KYA Portal
        <p class="lead mt-2">Wakala Contract</p>
      </div>
    </h4>

    <div class="row">
      <div class="col-12">
        <div id="scrollable-content" class="mb-4">
          <embed src="../pdf/Agency-Agreement.pdf" width="900px" height="600px" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-6 mt-2">
        <form
          @submit.prevent="showForms"
          class="mb-3"
          id="loginForm"
          novalidate
        >
          <div class="form-group">
            <div class="input-group with-focus">
              <input
                name="recruiterPhone"
                class="form-control border-right-0"
                type="text"
                placeholder="Enter Phone Number e.g 255754..."
                v-model="fields.msisdn"
              />
              <div class="input-group-append">
                <span
                  class="input-group-text text-muted bg-transparent border-left-0"
                >
                  <em class="fa fa-phone"></em>
                </span>
              </div>
            </div>

            <div v-if="errors && errors.msisdn" class="text-danger">
              {{ errors.msisdn[0] }}
            </div>
          </div>

          <button type="submit" class="btn btn-lg btn-danger">Get OTP</button>
        </form>
      </div>
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
    };
  },
  methods: {
    showForms() {
      this.errors = {};
      this.message = null;

      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        "is-full-page": false,
        loader: "dots",
        color: "red",
      });

      axios
        .post("/api/wakala/onboard/getcontractOTP", this.fields)
        .then((response) => {
          //console.log(response.data);
          this.fields = {}; //Clear input fields.

          loader.hide();

          var _this = this;

          Swal.fire({
            title: "Enter OTP token ",
            input: "text",
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Agree !',
            // inputValidator: value => {
            //     if (!value) {
            //         return "You need to write something!";
            //     }
            // }
          }).then(function (code) {
            console.log(_this.fields);
            if (code.isConfirmed) {
              _this.fields.confirmationCode = code.value;
              axios
                .post("/api/wakala/onboard/verify-contractOTP", _this.fields)
                .then((res) => {
                  _this.$router.push({
                    name: "onboard-wakala-nida",
                  });
                })
                .catch((error) => {
                  console.log(error);
                  loader.hide();
                  if (error.response.status === 422) {
                    this.errors = Toast.fire({
                      icon: "error",
                      title: error.response.data.errors.confirmationCode[0],
                    });
                  } else {
                    Swal.fire({
                      icon: "error",
                      title: "Oops...",
                      text: "Something went wrong!",
                    });
                  }
                });
            }
          });
        })
        .catch((error) => {
          loader.hide();
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            });
          }
        });
    },
  },
};
</script>

<style scoped>
#scrollable-content {
  overflow-y: auto;
}
</style>

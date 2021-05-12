<template>
  <div class="vld-parent" ref="formContainer">
    <div class="clearfix"></div>
    <div v-show="message" class="alert alert-danger alert-block mt-1">
      <span class="lead">{{ message }}</span>
    </div>
    <h4>
      <p class="text-center py-2 h6 text-bold">ONE TIME PIN (OTP)</p>
    </h4>
    <form @submit.prevent="submit" class="mb-3" id="loginForm" novalidate>
      <p class="text-center">Enter your 6 digits PIN to complete signin.</p>
      <div class="form-group">
        <div class="input-group with-focus">
          <input
            name="otp"
            class="form-control border-right-0"
            id="resetInputEmail1"
            type="text"
            placeholder="Enter your OTP e.g 122126"
            v-model="fields.otp"
          />
          <div class="input-group-append">
            <span
              class="input-group-text text-muted bg-transparent border-left-0"
            >
              <em class="fa fa-key"></em>
            </span>
          </div>
        </div>
        <div v-if="errors && errors.otp" class="text-danger">
          {{ errors.otp[0] }}
        </div>
      </div>
      <button class="btn btn-danger btn-block" type="submit">Verify PIN</button>
      <div class="float-right">
        <a
          v-on:click="resendOTP"
          href="#"
          class="text-lg-right font-weight-bold"
          >Resend PIN?</a
        >
      </div>
    </form>
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
  mounted() {
    loading: false;
  },
  methods: {
    submit() {

        let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        "is-full-page": false,
        loader: "dots",
        color: "red",
      });

      if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        this.message = null;
        axios
          .post("/api/auth/otp", this.fields)
          .then((response) => {
            console.log(response.data);
            this.fields = {}; //Clear input fields.
            this.loaded = true;
            this.success = true;
            loader.hide();

            const person = {
              name: sessionStorage.getItem("name"),
              status: true,
            };

            sessionStorage.setItem("user", JSON.stringify(person));

            localStorage.removeItem("name");

            window.location.href = "home";

          })
          .catch((error) => {
            this.loaded = true;
            loader.hide();
            console.log(error);
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            } else if (error.response.status === 400) {
              this.message = error.response.data.message;
            }
          });
      }
    },
    resendOTP() {
      axios
        .post("/api/auth/resend-otp")
        .then((response) => {
          console.log(response.data);
          this.fields = {}; //Clear input fields.
          this.loaded = true;
          this.success = true;

          Toast.fire({
            icon: "success",
            title: "New OTP sent successful",
          });

        })
        .catch((error) => {
          this.loaded = true;

          console.log(error);
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          } else if (error.response.status === 400) {
            this.message = error.response.data.message;
          }
        });
    },
  },
};
</script>

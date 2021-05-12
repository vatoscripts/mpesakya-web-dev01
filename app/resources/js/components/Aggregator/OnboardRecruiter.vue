<template>
  <div class="content-wrapper">
    <h4 class="content-heading">
      <div>
        M-pesa KYA Portal
        <p class="lead mt-2">Onboard Aggregator: NIDA verification</p>
      </div>
    </h4>
    <div class="col-8">
      <div class="clearfix"></div>
      <div
        v-show="message"
        class="alert alert-warning alert-block mt-1 text-center"
      >
        <span class="h3">{{ message }}</span>
      </div>
      <form @submit.prevent="submit" class="mb-3" id="loginForm" novalidate>
        <div class="form-group">
          <label class="text-bold">NIDA Number</label>
          <input
            id="NIN"
            name="NIN"
            class="form-control"
            type="text"
            placeholder="Enter NIDA number"
            v-model="fields.NIN"
          />
          <div v-if="errors && errors.NIN" class="text-danger">
            {{ errors.NIN[0] }}
          </div>
        </div>

        <div class="form-group">
          <label class="text-bold">Recruiter Category</label>

          <select
            class="form-control"
            name="recruiterCategory"
            id="aggregator-category-dropdown"
            v-model="fields.recruiterCategory"
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
          <div v-if="errors && errors.recruiterCategory" class="text-danger">
            {{ errors.recruiterCategory[0] }}
          </div>
        </div>

        <button
          id="sendAggregatorNIDA"
          type="submit"
          class="btn btn-lg btn-primary"
        >
          <span class="fa fa-save"></span> Proceed
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import ChildComponent from "../FormHelper.vue";

export default {
  data() {
    return {
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      loading: true,
      message: null,
      categories: [{ ID: 5, Description: "Wakala Recruiter" }],
    };
  },
  mounted() {
    loading: false;
  },
  methods: {
    submit() {
      axios
        .post("/api/aggregator/onboard", this.fields)
        .then((response) => {})
        .catch((error) => {
          this.loaded = true;

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

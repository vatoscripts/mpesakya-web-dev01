<template>
  <div class="content-wrapper">
    <h4 class="content-heading">
      <div>
        M-pesa KYA Portal
        <p class="lead mt-2">Onboarded Aggregator List</p>
      </div>
    </h4>
    <div class="vld-parent" ref="formContainer">
      <div class="clearfix"></div>
      <div
        v-show="message"
        class="alert alert-warning alert-block mt-1 text-center"
      >
        <span class="h3">{{ message }}</span>
      </div>

      <div class="table-responsive" v-show="!message">
        <vue-table-dynamic :params="params" ref="table"> </vue-table-dynamic>
      </div>

      <!-- <div class="table-responsive">
        <table
          class="table table-striped table-bordered table-hover"
          id="table-ext-3"
        >
          <thead>
            <tr>
              <th>Full Name</th>
              <th>Business Name</th>
              <th>Short Code</th>
              <th>Created Date</th>
              <th>Territory</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="aggregator in aggregators"
              v-bind:key="aggregator.AgregatorID"
            >
              <td>{{ aggregator.FULLNAME }}</td>
              <td>{{ aggregator.AgregatorBusinessName }}</td>
              <td>{{ aggregator.AgregatorShortCode }}</td>
              <td>{{ aggregator.CreatedDate }}</td>
              <td>{{ aggregator.TerritoryName }}</td>
            </tr>
          </tbody>
        </table>
      </div> -->
    </div>
  </div>
</template>

<script>
import VueTableDynamic from "vue-table-dynamic";
export default {
  components: { VueTableDynamic },
  data() {
    return {
      aggregator: "",
      aggregators: null,
      message: null,
      params: {
        data: [
          [
            "Full Name",
            "Business Name",
            "Short Code",
            "Created Date",
            "Territory",
          ],
        ],
        header: "row",
        border: true,
        stripe: true,
        pagination: true,
        pageSize: 4,
        sort: [0, 1, 2, 3, 4],
        // pageSizes: [5, 10, 20, 50]
      },
    };
  },
  mounted() {
    this.getlist();
  },
  methods: {
    getlist() {
      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        "is-full-page": true,
        loader: "dots",
        color: "red",
      });

      setTimeout(() => {
        axios
          .get("/api/aggregator/all")
          .then((response) => {
            //this.aggregators = response.data;

            let items = response.data;

            if (items.length > 0) {
              items.forEach((el) => {
                this.params.data.push([
                  el.FULLNAME,
                  el.AgregatorBusinessName,
                  el.AgregatorShortCode,
                  el.CreatedDate,
                  el.TerritoryName,
                ]);
              });
            } else {
              this.errorMessage = "No avaliable onboarded Aggregators !";
            }

            loader.hide();
          })
          .catch((error) => {
            loader.hide();
            Toast.fire({
              icon: "error",
              title: "An error occured while fetching aggregators : " + error,
            });
          });
      }, 1000);
    },
  },
};
</script>

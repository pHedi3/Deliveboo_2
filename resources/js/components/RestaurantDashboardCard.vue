<template>
  <div class="col-sm-12 col-lg-6">
    <!-- <div class="img">
      <div class="example-img">pippo</div>
    </div> -->
    <div class="card mb-3" style="max-width: 540px">
      <div class="row no-gutters">
        <div class="col-md-4">
          <img class="img-re" src="/img/restaurant.jpg" alt="" />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">{{ name }}</h5>
            <p class="card-text">
              <small
                v-for="element in category"
                :key="element.id"
                class="text-muted"
                >{{ element.name }} {{ rId }}</small
              >
            </p>
            <p class="card-text">
              {{ address }}
            </p>
            <div class="re-buttons">
              <a class="btn btn-primary button-login" :href="'/menù/' + rId"
                >Modifica Menu</a
              >

              <a
                :href="'/orders/' + rId"
                type="submit"
                class="btn btn-primary button-login"
              >
                Ordini
              </a>
              <a
                :href="'/stats/' + rId"
                type="submit"
                class="btn btn-primary button-login"
              >
                Statistiche
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: String,
    address: String,
    img: String,
    category: Array,
    rId: Number,
  },
  mounted() {
    this.getCourses();
    function modal() {
      $("#openBtn").click(function () {
        $("#myModal").modal({ show: true });
      });
    }
  },
  data() {
    return {
      dishes: [],
      courses: [],
      dishName: "",
      dishCourse: "",
      dishPrice: "",
      dishIngredients: "",
    };
  },
  methods: {
    getDishes(rId) {
      axios.get("/api/dishes/" + rId).then((response) => {
        this.dishes = response.data.data;
        console.log(response);
      });
    },
    getCourses() {
      axios.get("/api/courses").then((response) => {
        this.courses = response.data;
        console.log(response.data);
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.img-re {
  width: 100%;
  height: 100%;
}
.button-login {
  margin-bottom: 10px;
}
.modal:nth-of-type(even) {
  z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
  z-index: 1051 !important;
}
</style>

<template>
  <div class="col-sm-12 col-md-6">
    <!-- <div class="img">
      <div class="example-img">pippo</div>
    </div> -->
    <div class="card mb-3" style="max-width: 540px">
      <div class="row no-gutters">
        <div class="col-md-4"></div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">{{ name }}</h5>
            <p class="card-text">
              <small class="text-muted">{{ category }} {{ rId }}</small>
            </p>
            <p class="card-text">
              {{ address }}
            </p>
            <div class="re-buttons">
              <button
                @click="getDishes(rId)"
                type="submit"
                class="btn btn-primary button-login"
                data-toggle="modal"
                data-target="#exampleModal"
              >
                Menu
              </button>
              <!-- Modal -->
              <div
                class="modal fade"
                id="exampleModal"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">
                        Menu {{ name }}
                      </h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <ul
                          v-for="course in courses"
                          :key="course.id"
                          class="col-sm-12 col-md-6"
                        >
                          {{
                            course.name
                          }}
                          <li v-for="dish in dishes" :key="dish.id">
                            {{ dish.name }}
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                      >
                        Close
                      </button>
                      <button type="button" class="btn btn-primary">
                        Save changes
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- FINE MODALE -->

              <button type="submit" class="btn btn-primary button-login">
                Ordini
              </button>
              <button type="submit" class="btn btn-primary button-login">
                Statistiche
              </button>
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
    category: String,
    rId: Number,
  },
  mounted() {
    this.getCourses();
  },
  data() {
    return {
      dishes: [],
      courses: [],
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
.img {
  width: 100%;
  .example-img {
    width: 100%;
    height: 200px;
    background-color: red;
  }
}
</style>

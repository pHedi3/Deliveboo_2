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
                          <li
                            v-show="course.name == dish.course.name"
                            v-for="dish in dishes"
                            :key="dish.id"
                          >
                            {{ dish.name }}
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <!-- INIZIO MODALE NESTED -->

                      <a
                        data-toggle="modal"
                        href="#myModal"
                        class="btn btn-primary"
                        >Aggiungi Un Piatto</a
                      >

                      <div class="modal" id="myModal">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Modal title</h4>
                              <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true"
                              >
                                ×
                              </button>
                            </div>
                            <div class="container"></div>

                            <!-- FORM CREATE DISH NESTED -->

                            <div class="modal-body">
                              <form>
                                <div class="form-group">
                                  <label for="exampleFormControlInput1"
                                    >Nome Del Piatto</label
                                  >
                                  <input
                                    v-model="dishName"
                                    type="text"
                                    class="form-control"
                                    id="exampleFormControlInput1"
                                  />
                                </div>
                                <div class="form-group">
                                  <label for="exampleFormControlSelect1"
                                    >Tipo Di Portata</label
                                  >
                                  <select
                                    v-model="dishCourse"
                                    class="form-control"
                                    id="exampleFormControlSelect1"
                                  >
                                    <option selected>...</option>
                                    <option
                                      v-for="course in courses"
                                      :key="course.id"
                                    >
                                      {{ course.name }}
                                    </option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="exampleFormControlTextarea1"
                                    >Ingredienti</label
                                  >
                                  <textarea
                                    v-model="dishIngredients"
                                    class="form-control"
                                    id="exampleFormControlTextarea1"
                                    rows="3"
                                  ></textarea>
                                </div>
                                <div class="form-group">
                                  <label for="exampleFormControlInput1"
                                    >Prezzo</label
                                  >
                                  <input
                                    v-model="dishPrice"
                                    type="number"
                                    class="form-control"
                                    id="exampleFormControlInput1"
                                  />
                                </div>
                              </form>

                              <!-- FINE FORM CREATE DISH NESTED -->
                            </div>
                            <div class="modal-footer">
                              <a href="#" data-dismiss="modal" class="btn"
                                >Close</a
                              >
                              <a href="#" class="btn btn-primary"
                                >Save changes</a
                              >
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- FINE NESTED MODALE -->

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

.modal:nth-of-type(even) {
  z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
  z-index: 1051 !important;
}
</style>

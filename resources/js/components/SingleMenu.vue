<template>
  <div class="back">
    <div class="container">
      <div class="row p-2">
        <div class="col-6 col-md-12 p-2">
          <!--CARD RISTORANTE-->
          <div class="mycard">
            <img src="/img/restaurant.jpg" alt="" />
            <div class="inner-card">
              <div>
                <h4>{{ restaurant.name }}</h4>
                <h5 v-for="element in restaurant.category" :key="element.id">
                  {{ element.name }}
                </h5>
                <h6>{{ restaurant.address }}</h6>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-2 p-2">
          <a href="/dashboard" class="btn btn-primary button-login">
            Vai alla Dashboard
          </a>
        </div>
      </div>
      <div class="row accordion-2">
        <div class="accordion col" id="accordionExample">
          <div class="card" v-for="item in course" :key="item.id">
            <div class="card-header" :id="item.name">
              <h2 class="mb-0">
                <button
                  class="btn btn-link btn-block text-left button-accordion"
                  type="button"
                  data-toggle="collapse"
                  :data-target="'#' + item.name + item.id"
                  aria-expanded="true"
                  :aria-controls="item.name + item.id"
                >
                  {{ item.name }}
                </button>
              </h2>
            </div>

            <div
              :id="item.name + item.id"
              class="collapse"
              :aria-labelledby="item.name"
              data-parent="#accordionExample"
            >
              <div class="card-body">
                <ul class="dishes-list">
                  <li
                    v-show="item.name == singleDish.course.name"
                    v-for="singleDish in dish"
                    :key="singleDish.id"
                  >
                    {{ singleDish.name }}

                    <!-- TASTO CHE APRE LA MODALE PER MODIFICARE IL PIATTO -->
                    <button
                      @click="
                        getCourseId(
                          item.id,
                          singleDish.name,
                          singleDish.ingredients,
                          singleDish.price
                        )
                      "
                      type="button"
                      class="btn btn-primary button-login"
                      data-toggle="modal"
                      :data-target="'#exampleModalModify' + singleDish.id"
                    >
                      <i class="fas fa-edit"></i>
                    </button>

                    <!-- FINE MODALE MODIFICA PIATTI -->

                    <button
                      @click="destroyDish(singleDish.id)"
                      class="btn btn-primary button-login"
                    >
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </li>
                </ul>

                <!-- TASTO CHE APRE LA MODALE AGGIUNGERE UN PIATTO -->

                <button
                  @click="getCourseId(item.id)"
                  type="button"
                  class="btn btn-primary button-login"
                  data-toggle="modal"
                  :data-target="'#exampleModal' + item.name + item.id"
                >
                  Aggiungi un piatto
                </button>

                <!-- APERTURA MODALE CREAZIONE PIATTO -->

                <div
                  class="modal fade"
                  :id="'exampleModal' + item.name + item.id"
                  tabindex="-1"
                  :aria-labelledby="'exampleModalLabel' + item.name + item.id"
                  aria-hidden="true"
                >
                  <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5
                          class="modal-title"
                          :id="'exampleModalLabel' + item.name + item.id"
                        >
                          Modal title
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
                        <ValidationErrors
                          :errors="validationErrors"
                          v-if="validationErrors"
                        />
                        <!-- INIZIO FORM IN MODALE -->
                        <form>
                          <div class="form-group">
                            <label :for="'FormNomePiatto' + item.name + item.id"
                              >Nome del piatto</label
                            >
                            <input
                              v-model="dishName"
                              type="text"
                              class="form-control"
                              :id="'FormNomePiatto' + item.name + item.id"
                            />
                          </div>
                          <div class="form-group">
                            <label
                              :for="'FormControlSelect' + item.name + item.id"
                              >Portata</label
                            >
                            <select
                              class="form-control"
                              :id="'FormControlSelect' + item.name + item.id"
                            >
                              <option selected>{{ item.name }}</option>
                            </select>
                          </div>
                          <div class="form-group d-none">
                            <input
                              :value="item.id"
                              class="courseId"
                              type="text"
                            />
                          </div>
                          <div class="form-group">
                            <label
                              :for="
                                'FormControlIngredients' + item.name + item.id
                              "
                              >Ingredienti</label
                            >
                            <textarea
                              v-model="dishIngredients"
                              class="form-control"
                              :id="
                                'FormControlIngredients' + item.name + item.id
                              "
                              rows="3"
                            ></textarea>
                          </div>
                          <div class="form-group">
                            <label
                              :for="'FormControlPrice' + item.name + item.id"
                              >Prezzo</label
                            >
                            <input
                              v-model="dishPrice"
                              type="number"
                              class="form-control"
                              :id="'FormControlPrice' + item.name + item.id"
                            />
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-dismiss="modal"
                        >
                          Close
                        </button>
                        <button
                          @click="postDish()"
                          type="button"
                          class="btn btn-primary button-login"
                        >
                          Crea Nuovo Piatto
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- CHIUSURA MODALE CREAZIONE PIATTO -->
              </div>
            </div>
          </div>
        </div>

        <!-- LOOP SEPARATO PER LE MODALI DI MODIFICA PIATTO -->
        <div v-for="modaldish in dish" :key="modaldish.id">
          <div
            class="modal fade"
            :id="'exampleModalModify' + modaldish.id"
            tabindex="-1"
            :aria-labelledby="'exampleModalLabelModify' + modaldish.id"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5
                    class="modal-title"
                    :id="'exampleModalLabelModify' + modaldish.id"
                  >
                    Modal title
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
                  <ValidationErrors
                    :errors="validationErrors"
                    v-if="validationErrors"
                  />
                  <!-- INIZIO FORM IN MODALE DI MODIFICA -->
                  <form>
                    <div class="form-group">
                      <label :for="'FormNomePiattoModify' + modaldish.id"
                        >Nome del piatto</label
                      >
                      <input
                        v-model="dishNameEdit"
                        type="text"
                        class="form-control"
                        :id="'FormNomePiattoModify' + modaldish.id"
                      />
                    </div>
                    <div class="form-group">
                      <label :for="'FormControlSelectModify' + modaldish.id"
                        >Portata</label
                      >
                      <select
                        class="form-control"
                        :id="'FormControlSelectModify' + modaldish.id"
                      >
                        <option selected>
                          {{ modaldish.course.name }}
                        </option>
                      </select>
                    </div>
                    <div class="form-group d-none">
                      <input
                        :value="modaldish.id"
                        class="courseId"
                        type="text"
                      />
                    </div>
                    <div class="form-group">
                      <label
                        :for="'FormControlIngredientsModify' + modaldish.id"
                        >Ingredienti</label
                      >
                      <textarea
                        v-model="dishIngredientsEdit"
                        class="form-control"
                        :id="'FormControlIngredientsModify' + modaldish.id"
                        rows="3"
                      ></textarea>
                    </div>
                    <div class="form-group">
                      <label :for="'FormControlPriceModify' + modaldish.id"
                        >Prezzo</label
                      >
                      <input
                        v-model="dishPriceEdit"
                        type="number"
                        class="form-control"
                        :id="'FormControlPriceModify' + modaldish.id"
                      />
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >
                    Close
                  </button>
                  <button
                    @click="changeDish(modaldish.id)"
                    type="button"
                    class="btn btn-primary button-login"
                    data-dismiss="modal"
                  >
                    Modifica Piatto
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- FINE LOOP MODALI MODIFICA PIATTO -->
      </div>
    </div>
  </div>
</template>

<script>
import ValidationErrors from "./ValidationErrors.vue";

export default {
  components: { ValidationErrors },
  data() {
    return {
      restaurant: {},
      dish: [],
      course: [],
      cart: [],
      showid: 0,
      flagModal: false,
      dishName: "",
      dishCourse: "",
      dishIngredients: "",
      dishPrice: "",
      dishNameEdit: "",
      dishIngredientsEdit: "",
      dishPriceEdit: "",
      getDishId: "",
      validationErrors: "",
    };
  },
  props: {
    id: Number,
  },
  created() {
    console.log("Component mounted.");
    this.getRestaurant();
    this.getDish();
    this.getCourse();
  },
  computed: {
    correctName(dishname) {
      return dishname.toString().replace(" ", "-");
    },
  },
  methods: {
    getRestaurant() {
      axios.get("/api/restaurants/" + this.id).then((response) => {
        console.log(response.data.data);
        this.restaurant = response.data.data;
      });
    },
    getDish() {
      axios.get("/api/dishes/" + this.id).then((response) => {
        console.log(response.data.data);
        this.dish = response.data.data;
      });
      console.log("ciao");
    },
    getCourse() {
      axios.get("/api/courses").then((response) => {
        console.log(response.data.data);
        this.course = response.data;
      });
    },
    getCourseId(courseid, name, ingredients, price) {
      this.dishCourse = courseid;
      this.dishNameEdit = name;
      this.dishIngredientsEdit = ingredients;
      this.dishPriceEdit = price;
    },
    postDish() {
      axios
        .post("/api/dishes", {
          name: this.dishName,
          price: this.dishPrice,
          ingredients: this.dishIngredients,
          course_id: this.dishCourse,
          restaurant_id: this.id,
        })
        .then((response) => {
          console.log(response.data.data);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.validationErrors = error.response.data.errors;
          }
        });

      this.dishName = "";
      this.dishPrice = "";
      this.dishIngredients = "";
      this.dishCourse = "";
      setTimeout(() => {
        this.getDish();
      }, 2000);
    },
    // getDishInfo(name, ingredients, price) {
    //   this.dishNameEdit = name;
    //   this.dishIngredientsEdit = ingredients;
    //   this.dishPriceEdit = price;
    // },
    changeDish(dishid) {
      this.getDishId = dishid;
      axios
        .put("/api/dishes/" + this.getDishId, {
          name: this.dishNameEdit,
          price: this.dishPriceEdit,
          ingredients: this.dishIngredientsEdit,
          course_id: this.dishCourse,
          restaurant_id: this.id,
        })
        .then((response) => {
          console.log(response.data.data);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.validationErrors = error.response.data.errors;
          }
        });
      this.dishNameEdit = "";
      this.dishPriceEdit = "";
      this.dishIngredientsEdit = "";
      this.dishCourse = "";
      this.getDishId = "";
      setTimeout(() => {
        this.getDish();
      }, 3000);
    },
    destroyDish(dishid) {
      this.getDishId = dishid;
      axios.delete("/api/dishes/" + this.getDishId).then((response) => {
        console.log(response);
      });
      this.getDish();
      this.getDishId = "";
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../sass/app.scss";
.mycard {
  background-color: rgba($color: #ffffff, $alpha: 0.8);
  height: 150px;
  overflow: hidden;
  position: relative;
  border-radius: 12px;
  padding: 8px;

  img {
    width: 100%;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  h5,
  h6 {
    font-weight: 400;
    text-align: center;
    color: #555;
  }
  .inner-card {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba($color: #000, $alpha: 0.6);
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    h5,
    h6 {
      color: white;
    }
  }

  h4 {
    margin-top: 8px;
    font-weight: 900;
    text-align: center;
  }
}

.back {
  background-color: $background;
  .course {
    background-color: rgba($color: #ffffff, $alpha: 0.8);
    border-radius: 12px;
    padding: 8px;
    margin-top: 12px;
    .inner-dish {
      display: inline-block;
    }
    button {
      background-color: $background2;
      color: $main-title;
      border: $background2;

      &:hover,
      &:active,
      &:visited,
      &:focus {
        background-color: $background2 !important;
        color: $main-title !important;
        border-color: $main-title !important;
      }

      &:active,
      &:focus,
      &:visited {
        box-shadow: 0 0 2px 2px $main-title !important;
      }
    }
  }
}

.accordion {
  margin-bottom: 20px;
}

.dishes-list {
  
  li {
    margin-top: 20px;
    button {
      margin-left: 10px;
    }
  }
}

.card-header{
  background: rgba(151, 150, 150, 0.199);
}

.text-left{
  text-decoration: none;
  color: $main-title !important;
  &:hover{
    text-decoration: none;
    color: $main-title !important;
  }
}
.button-accordion{
  border: rgba(175, 169, 169, 0.637) solid 2px;
}
</style>

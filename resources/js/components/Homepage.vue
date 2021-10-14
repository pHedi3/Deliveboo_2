<template>
    <div class="homepage">
        <div class="back">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <h1>Ordina qui dal tuo ristorante di fiducia</h1>
                        <div class="row p-1">
                            <div class="search col-lg-12 col-md-10 col-12">
                                <div>
                                    <h2>Cerca il tuo ristorante preferito</h2>
                                </div>
                                <div class=" d-flex">
                                    <input v-model="search" type="text" placeholder="Inserisci qui il nome">
                                    <button @click="getRestaurantSearch" class="button-search">Cerca</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <div class="jumbo">
                              <img src="/img/img-jumbo.webp" alt="jumbo-img"><!--responsive img-->
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
        <div class="category" v-if="flegCategory">
            <div class="container">
                <div class="row">
                    <button class="col-lg-2 col-md-4 col-sm-6 col-12 p-1" v-for="(element, index) in category" :key="index" 
                    @click="getCategorySearch(element.id)"> 
                        <category-card 
                        :name="element.name"
                        :img="element.img"/>
                    </button><!--  to do, rimanenere in active dopo la ricerca -->
                </div>
            </div>
        </div>
        <div class="restaurant">
            <div class="container">
                <div class="row">
                    <restaurant-card v-for="(element, index) in restaurants " :key="index" 
                    :name="element.name"
                    :address="element.address"
                    :img="element.img"
                    :category="element.category"
                    :id="element.id"/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import CategoryCard from './CategoryCard.vue';
import RestaurantCard from './RestaurantCard.vue';
export default {
  components: { RestaurantCard, CategoryCard },
  data() {
    return {
      search: "",
      restaurants: [],
      category: [],
      flegCategory: true

    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getCategory();
  },
  methods: {
    getRestaurantSearch() {
      axios.get("/api/restaurantsearch/" + this.search).then((response) => {
        console.log(response.data);
            this.restaurants = response.data.data
            this.flegCategory = false
      });
    },
    getCategory() {
      axios.get("/api/categories").then((response) => {
        console.log(response.data);
            this.category = response.data
      });
    },
    getCategorySearch(id) {
      axios.get("/api/categorysearch/" + id).then((response) => {
        console.log(response.data.data);
            this.restaurants = response.data.data
      });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../sass/app.scss";

.homepage {
    .jumbo{
        display: none;
    }
    @media(min-width:768px) {
        .jumbo {
            display: block; /*DISPLAY NONE */
        }
    }
}
.category {
    
    button {
        border: none;
        background-color: white;    
        &:hover {
            opacity: 0.8;
        }
        .mycard {
            border: 2px solid transparent;
            &:active {
                border-color: $main-title !important;

            }
        }
      
    }
    
}

.back {
    background: linear-gradient(174deg, rgba(225,221,143,1) 0%, rgba(225,221,143,1) 50%, rgba(224,119,125,1) 51%);
    height: 300px;
    padding: 24px 0;

    h1 {
        color: $second-title;
        font-weight: bold;
    }
    .search {
        margin-top: 24px;
        background-color: white;
        border-radius: 12px;
        padding: 12px;
        h2 {
            font-size: 16px;
        }
        input {
            flex-grow: 1;
            margin-right: 12px;
        }
    }
    img {
        height: 252px;
        border-radius: 50%;
    }
}
.restaurant {
    padding: 24px 0;
    background-color: $background;
}
.button-search{
    background-color: $background2;
    color: $main-title;
    border: $background2;
    

    &:hover , &:active , &:visited , &:focus{
        background-color: $background2 !important;
        color: $main-title !important;
        border-color: $main-title !important;
    }

    &:active , &:focus, &:visited{
        box-shadow: 0 0 2px 2px $main-title !important;
        
    }
}
</style>

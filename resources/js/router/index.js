import { createRouter, createWebHistory } from 'vue-router';
import BikeList from '../components/BikeList.vue';
import EditBike from '../components/EditBike.vue';
import CreateBike from '../components/CreateBike.vue';

const routes = [
  {
    path: '/',
    component: BikeList,
  },
  {
    path: '/bikes/create',
    component: CreateBike,
  },
  {
    path: '/bikes/:id/edit',
    component: EditBike,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
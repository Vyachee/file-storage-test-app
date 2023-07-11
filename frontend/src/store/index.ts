import { createStore } from 'vuex'
import api from "@/api";

// Нужно было это в модули всё разнести по-хорошему, но тут не так уж и много
export default createStore({
  state: {
      files: [],
      meta: [],
      currentPage: 'main',
      query: null,
      showConfirm: false,
      confirmCallback: null
  },
  getters: {

  },
  mutations: {
      SET_FILES(state, payload) {
          state.files = payload
      },
      SET_META(state, payload) {
          state.meta = payload
      },
      SET_PAGE(state, payload) {
          state.currentPage = payload
      },
      SET_QUERY(state, payload) {
          state.query = payload
      },
      SET_SHOW_CONFIRM(state, payload) {
          state.showConfirm = payload
      },
      SET_CONFIRM_CALLBACK(state, payload) {
          state.confirmCallback = payload
      },
  },
  actions: {
      confirm(context) {
          // @ts-ignore
          context.state.confirmCallback?.()
      },
      async fetchFiles(context, payload) {
          const {data: {
              data, meta
          }} = await api.get(
              'files',
              {params: payload}
          );
          context.commit('SET_FILES', data)
          context.commit('SET_META', meta)
      },
      async deleteFile(context, payload) {
          const {data: {
              success,
              message
          }} = await api.delete(
              `files/${payload}`
          );

          if(success) {
              context.commit('SET_SHOW_CONFIRM', false);
              await context.dispatch("fetchFiles")
          } else {
              alert(message)
          }
      }
  },
  modules: {
  }
})

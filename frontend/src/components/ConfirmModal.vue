<template>
  <div class="confirm-modal">
      <div class="confirm-modal-backdrop" @click="cancel"></div>
      <div class="confirm-modal-window">
          <h2>Подтвердите действие</h2>
          <div class="confirm-modal-window-actions">
              <div class="confirm-modal-window-actions-confirm" @click="confirm">
                  Подтвердить
              </div>
              <div class="confirm-modal-window-actions-cancel" @click="cancel">
                  Отмена
              </div>
          </div>
      </div>
  </div>
</template>

<script setup lang="ts">
import store from "@/store";

const cancel = () => {
    console.log('test')
    store.commit('SET_SHOW_CONFIRM', false);
}

const confirm = () => {
    store.dispatch('confirm')
}
</script>

<style lang="scss" scoped>
.confirm-modal {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    &-backdrop {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, .5);
        z-index: -1;
        transition: .2s;
        cursor: pointer;

        &:hover {
            background-color: rgba(0, 0, 0, .55);
        }
    }

    &-window {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background-color: #fff;
        z-index: 12;
        &-actions {
            display: flex;
            gap: 10px;
            &-confirm, &-cancel {
                padding: 10px 20px;
                text-align: center;
                color: #fff;
                background-color: #333333;
                width: 100%;
                transition: .3s;
                cursor: pointer;

                &:hover {
                    background-color: #1a1a1a;
                }
            }

            &-confirm {
                flex: 0;
            }

            &-cancel {
                flex: 3;
                width: 200px;
            }
        }
    }
}
</style>

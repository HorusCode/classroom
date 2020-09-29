/*
* Кнока открытия модального окна менеджера
* */

import {Image} from 'element-tiptap';
import FilemanagerButton from './FilemanagerButton';

export default class Filemanager extends Image {
    menuBtnView(editorContext) {
        return {
            component: FilemanagerButton,
            componentProps: {
                editorContext,
                tooltip: 'Файловый менеджер',
            },
        };
    }
}

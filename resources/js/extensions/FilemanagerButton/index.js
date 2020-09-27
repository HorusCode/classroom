/*
* Element TipTap open filemanager button
* */

import {Link} from 'element-tiptap';
import FilemanagerButton from './FilemanagerButton';

export default class Filemanager extends Link {
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

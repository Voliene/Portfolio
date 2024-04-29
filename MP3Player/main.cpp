#include <iostream>
#include <cstdlib>
#include <windows.h>
#include "menu.h"
using namespace std;
#include <locale>
#include <codecvt>


int main() {
        HANDLE outcon = GetStdHandle(STD_OUTPUT_HANDLE);//you don't have to call this function every time
 /*
    CONSOLE_FONT_INFOEX font;//CONSOLE_FONT_INFOEX is defined in some windows header
    GetCurrentConsoleFontEx(outcon, false, &font);//PCONSOLE_FONT_INFOEX is the same as CONSOLE_FONT_INFOEX*
    font.dwFontSize.X = 12;
    font.dwFontSize.Y = 24;
    SetCurrentConsoleFontEx(outcon, false, &font);
 */


    Menu menu;
    SetConsoleTextAttribute(outcon, 0x0DF);
    cout << "Witajcie w odtwarzaczu mp3!" << endl;
    cout << menu.volume << endl;
    menu.Showmenu();
    menu.AsknrInstr();
    menu.SetnrInstr();
     while(menu.nrInstr !=5){

    if (menu.nrInstr == 1) {
        menu.Showmenu();
        menu.AsknrInstr();
        menu.SetnrInstr();
    }
    if (menu.nrInstr == 2) {
        //if (menu.nr != 0)  menu.Closenr();
        menu.Asknr();
        menu.Setnr();
        menu.Closenr();
        menu.Playnr();
        menu.AsknrInstr();
        menu.SetnrInstr();
    }
    if (menu.nrInstr == 3) {
        if (menu.nr ==false){
            menu.FalseInstr();
            menu.AsknrInstr();
            menu.SetnrInstr();
 
        }
        else {
            menu.Stopnr();
            menu.AsknrInstr();
            menu.SetnrInstr();
        }
    }
    if (menu.nrInstr ==4) {
        if (menu.nr == false) {
            menu.FalseInstr();
            menu.AsknrInstr();
            menu.SetnrInstr();

        }
        else {
            menu.Playnr();
            menu.AsknrInstr();
            menu.SetnrInstr();
        }

    }
    if (menu.nrInstr == 6) {
        menu.VolumeDown();
        menu.AsknrInstr();
        menu.SetnrInstr();
    }
    if (menu.nrInstr == 7) {
        menu.VolumeUp();
        menu.AsknrInstr();
        menu.SetnrInstr();
    }
    if (menu.nrInstr != 1 && menu.nrInstr != 2 && menu.nrInstr != 3 && menu.nrInstr != 4 && menu.nrInstr != 5 && menu.nrInstr != 6 && menu.nrInstr != 7) {
        menu.FalseInstr();
        menu.AsknrInstr();
        menu.SetnrInstr();
    }

     }

   /* while (1) {
        menu.Showmenu();
        menu.Asknr();
        menu.Setnr();
        menu.Playnr();
        int n;
        cin >> n;
        if (n == 3) {
            exit(0);
        }
        if (n == 2) { menu.Stopnr(); }
    }*/
     
     
     SetConsoleTextAttribute(outcon, 0x0F);
}






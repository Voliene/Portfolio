#include <iostream>
#include "menu.h"
#include <windows.h>
#include <vector>
using namespace std;

#include <locale>
#include <codecvt>

#define MCI_ERROR_BUFFER_SIZE 300
HANDLE outcon = GetStdHandle(STD_OUTPUT_HANDLE);
std::string getErrorString(MCIERROR errorCode)
{
    TCHAR mciErrorString[MCI_ERROR_BUFFER_SIZE];
    bool success = mciGetErrorString(errorCode, mciErrorString, MCI_ERROR_BUFFER_SIZE);

    std::wstring wideErrorString(mciErrorString);

    // setup converter to convert from wide string to regular string
    using convert_type = std::codecvt_utf8<wchar_t>;
    std::wstring_convert<convert_type, wchar_t> converter;
    // convert 
    std::string errorString = converter.to_bytes(wideErrorString);

    return errorString;
}


Menu::Menu() {

	Tabnr = { 
		L"piosenki_z_plyty\\1.mp3 ", 
		L"piosenki_z_plyty\\2.mp3 ", 
		L"piosenki_z_plyty\\3.mp3 ",
		L"piosenki_z_plyty\\4.mp3 ",
		L"piosenki_z_plyty\\5.mp3 ",
		L"piosenki_z_plyty\\6.mp3 ", 
		L"piosenki_z_plyty\\7.mp3 ",
		L"piosenki_z_plyty\\8.mp3 ",
		L"piosenki_z_plyty\\9.mp3 ",
		L"piosenki_z_plyty\\10.mp3 ",
		L"piosenki_z_plyty\\11.mp3 ",
		L"piosenki_z_plyty\\12.mp3 " 
	};

	DWORD dwVolume;

	waveOutSetVolume(NULL, 0xFFFFFFFF);

}


Menu::~Menu() {
	cout << "" << endl;
}
void Menu::Showmenu() {
	SetConsoleTextAttribute(outcon, 0x0D);
	cout << "================================================================" << endl;
	cout << "================================================================" << endl;
	cout << "1.Utwor 1" << endl;
	cout << "2.Utwor 2" << endl;
	cout << "3.Utwor 3" << endl;
	cout << "4.Utwor 4" << endl;
	cout << "5.Utwor 5" << endl;
	cout << "6.Utwor 6" << endl;
	cout << "7.Utwor 7" << endl;
	cout << "8.Utwor 8" << endl;
	cout << "9.Utwor 9" << endl;
	cout << "10.Utwor 10" << endl;
	cout << "11.Utwor 11" << endl;
	cout << "12.Utwor 12" << endl;

}
void Menu::Asknr() {
	SetConsoleTextAttribute(outcon, 0x0E);
	cout << "\nKtora piosenka wybierasz? Wybierz numer piosenki" << endl;
}
int Menu::Setnr() {
	SetConsoleTextAttribute(outcon, 0x0B);
	cin >> nr;
	if (nr < 1 && nr > Tabnr.size()) nr = 0;
	while (nr < 1 && nr> Tabnr.capacity()) {
		cout << "Zly numer wpisz nowy" << endl;
		cin >> nr;
	}
	cout << "Wybrano piosenke nr " << nr << endl;
	return 1;
}
int Menu::Playnr() {
	//wstring OpenFile = L"open ";
	//wstring Alias = L"type mpegvideo alias mp3";
	//wstring CloseFile = L"close ";
	wstring wstrCommand = OpenFile + Tabnr[nr - 1] + Alias;


	mciSendString(wstrCommand.c_str(), NULL, 0, NULL);

	//auto errorCode = mciSendString(wstrCommand.c_str(), NULL, 0, NULL);
	//cout << getErrorString(errorCode);

	wstrCommand = L"play mp3";
	mciSendString(wstrCommand.c_str(), NULL, 0, NULL);
	SetConsoleTextAttribute(outcon, 0x0A);
	wcout << "Gram " << Tabnr[nr-1] << endl;

	return 1;


}
int Menu::Stopnr() {
	wstring wstrCommand = L"pause mp3";
	mciSendString(wstrCommand.c_str(), NULL, 0, NULL);
	SetConsoleTextAttribute(outcon, 0x0A);
	wcout << "Pauzuje " << Tabnr[nr-1] << endl;
	return 1;
}
int Menu::Closenr() {
	wstring wstrCommand = L"close mp3";
	mciSendString(wstrCommand.c_str(), NULL, 0, NULL);
	//SetConsoleTextAttribute(outcon, 0x0D);
	//wcout << "Zamykam " << Tabnr[nr - 1] << endl;
	return 1;
}
void Menu::AsknrInstr() {
	SetConsoleTextAttribute(outcon, 0x0E);
	cout << "================================================================\n"
		<< "================================================================\n"
		<< "Podaj instrukcje jaka mam wykonac (Wcisnij odpowiedni przycisk):\n"
		<< "1.Pokaz menu piosenek.\n"
		<< "2.Wybierz piosenke do zagrania\n"
		<< "3.Zapauzuj piosenke\n"
		<< "4.Odpauzuj piosenke\n"
		<< "5.Wylacz odtwarzacz\n"
	<< "6.Scisz\n"
	<< "7.Podglosnij\n";

}
int Menu::SetnrInstr() {
	cin >> nrInstr;
	return 1;
}
void Menu::FalseInstr() {
	SetConsoleTextAttribute(outcon, 0x0C);
	cout << "================================================================\n"
		<< "================================================================\n"
		<< "Wpisz prosze poprawny numer.\n";
}
int Menu::VolumeDown() {
	if (volume == 0x00000000) {
		volume = volume;
	}else{
	volume = volume - 0x138F138F;
	}
	waveOutSetVolume(NULL, volume);
	cout << volume << endl;
	return 1;
}
int Menu::VolumeUp() {
	if (volume == 0xFFFFFFFF) {
		volume = volume;
	} else {
	volume = volume + 0x138F138F;
	}
	waveOutSetVolume(NULL, volume);
	cout << volume << endl;
	return 1;
}
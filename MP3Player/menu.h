#pragma once
#include <iostream>
#include <vector>
using namespace std;
class Menu {
protected:

public:
	int nr=0; 
	int nrInstr = 0;
	int volume = 0x99999999;
	std::vector <std::wstring> Tabnr;
	wstring OpenFile = L"open ";
	wstring Alias = L"type mpegvideo alias mp3";
	wstring CloseFile = L"close ";
	//wstring wstrCommand = OpenFile + Tabnr[nr - 1] + Alias;
	Menu();
	~Menu();

	void Showmenu();
	void Asknr();
	int Setnr();
	int Playnr();
	int Stopnr();
	int Closenr();
	void AsknrInstr();
	int SetnrInstr();
	void FalseInstr();
	int VolumeDown();
	int VolumeUp();
};
